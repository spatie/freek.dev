<?php

namespace App\Services\MissingPageRedirector;

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\Redirect;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class LegacyUrlsRedirector implements Redirector
{
    public function getRedirectsFor(Request $request): array
    {
        $slug = $request->segment(1);

        $post = Post::where('slug', $slug)->first();

        if ($post) {
            return ["/{$slug}" => action(PostController::class, $post->idSlug())];
        }

        return Redirect::all()->flatMap(function ($redirect) {
            return [$redirect->old_url => $redirect->new_url];
        })->toArray();
    }
}
