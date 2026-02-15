<?php

namespace App\Http\Controllers\Auth;

use App\Models\Commenter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GitHubAuthController
{
    public function redirect(Request $request): RedirectResponse
    {
        $state = Str::random(40);
        $request->session()->put('github_oauth_state', $state);

        $query = http_build_query([
            'client_id' => config('services.github.client_id'),
            'redirect_uri' => route('auth.github.callback'),
            'scope' => 'read:user',
            'state' => $state,
        ]);

        return redirect("https://github.com/login/oauth/authorize?{$query}");
    }

    public function callback(Request $request): View
    {
        if ($request->input('state') !== $request->session()->pull('github_oauth_state')) {
            abort(403, 'Invalid state');
        }

        $tokenResponse = Http::acceptJson()->post('https://github.com/login/oauth/access_token', [
            'client_id' => config('services.github.client_id'),
            'client_secret' => config('services.github.client_secret'),
            'code' => $request->input('code'),
        ]);

        $accessToken = $tokenResponse->json('access_token');

        if (! $accessToken) {
            abort(403, 'Could not obtain access token');
        }

        $githubUser = Http::withToken($accessToken)
            ->get('https://api.github.com/user')
            ->json();

        $plainToken = Str::random(64);

        $commenter = Commenter::updateOrCreate(
            ['github_id' => $githubUser['id']],
            [
                'username' => $githubUser['login'],
                'name' => $githubUser['name'] ?? $githubUser['login'],
                'avatar_url' => $githubUser['avatar_url'],
                'token' => hash('sha256', $plainToken),
            ],
        );

        return view('auth.github-callback', [
            'token' => $plainToken,
            'commenter' => $commenter,
        ]);
    }
}
