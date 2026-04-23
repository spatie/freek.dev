<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\OgImage\Facades\OgImage;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->admin;
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        OgImage::fallbackUsing(fn () => view('og-images.default'));

        $this->aliasPublicDiskWithPrefix('admin-uploads', env('ADMIN_UPLOADS_URL'));
        $this->aliasPublicDiskWithPrefix('avatars', env('AVATARS_URL'));
    }

    protected function aliasPublicDiskWithPrefix(string $diskName, ?string $url): void
    {
        $publicDisk = config('filesystems.disks.public');

        if (! $publicDisk || ($publicDisk['driver'] ?? null) !== 's3') {
            return;
        }

        config(['filesystems.disks.'.$diskName => array_merge($publicDisk, [
            'root' => $diskName,
            'url' => $url ?: $publicDisk['url'] ?? null,
        ])]);
    }
}
