<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Ad;
use App\Nova\Comment;
use App\Nova\Dashboards\Main;
use App\Nova\Link;
use App\Nova\Post;
use App\Nova\Tag;
use App\Nova\Talk;
use App\Nova\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make('Content', [
                    MenuItem::resource(Post::class),
                    MenuItem::resource(Comment::class),
                    MenuItem::resource(Ad::class),
                    MenuItem::resource(Link::class),
                    MenuItem::resource(Talk::class),
                    MenuItem::resource(Tag::class),
                    MenuItem::resource(Video::class),
                ])->icon('document-text'),

                MenuItem::resource(\App\Nova\User::class),
            ];
        });
    }

    protected function gate()
    {
        Gate::define('viewNova', fn (User $user) => $user->admin);
    }

    protected function dashboards()
    {
        return [
            new Main(),
        ];
    }
}
