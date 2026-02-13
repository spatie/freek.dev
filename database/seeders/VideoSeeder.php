<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        Video::create([
            'title' => 'Building a Realtime Dashboard Powered by Laravel and Livewire',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/q7W2QW0UL8w?start=125" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => 'In this talk I demonstrate our laravel-dashboard package. It allows you to build a real-time dashboard powered by Laravel and Livewire, displaying team tasks, important events, music playing, and much more.',
        ]);

        Video::create([
            'title' => 'Behind the scenes of Flare',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/06--kezKc0Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => 'In this talk, recorded at Laracon Australia 2019, I explain a strategy to structure large Laravel applications, using Flare as an example.',
        ]);

        Video::create([
            'title' => 'Launching Flare and Ignition',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/flare-ignition-reveal" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "Together with Marcel Pociot and our teams, I created [Flare](https://flareapp.io), the best error tracking service for Laravel applications. Together with Flare we completely revamped Laravel's default error page which is baptized [Ignition](https://flareapp.io/ignition).\n\nIn this video you can see the initial reveal of both Flare and Ignition at Laracon EU 2019 in Amsterdam.",
        ]);

        Video::create([
            'title' => 'Taking care of backups with Laravel',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/fORNQ06K8LY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "Thanks to all the excellent resources on server management many developers are now setting up and administrating their own servers. If you are one of them you can't count on anybody else but yourself to backup the data of your clients.\n\nWe cover the backup issues presented when using modern hosting such as Linode and DigitalOcean. Then we review some enterprise grade solutions. Finally we dive deep into implementing a backup system using Laravel 5's filesystem abstraction.",
        ]);

        Video::create([
            'title' => 'Building a realtime dashboard with Laravel, Vue and Pusher',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jtB_rTh61Zo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "On the wall mounted TV in our office a dashboard is displayed. At a glance we can see what the current tasks for each member of our team are, which important events are coming up, which music is playing, ... and much more.\n\nIn this talk I explain how we leveraged both Laravel and Vue to build the dashboard. After demonstrating the dashboard itself we take a deep dive in the code. We take a look at the entire flow: the grid system, how events are broadcasted using Pusher, some cool Vue mixins and much more. After this talk you'll be able to setup your own dashboard using our open sourced code.",
        ]);

        Video::create([
            'title' => 'Handling media in a Laravel application',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ho9OVdxpFRM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "In most CMS kind of projects you're going to let a user upload all sorts of images and files. Storing those files, associating them with models, creating thumbnails for them, optimizing images, can be a lot of work. Luckily laravel-medialibrary can do all that for you.\n\nIn this talk you'll see a practical demo of how to get started with the medialibrary. You'll learn how to store files, generate urls to them, how to use different image profiles and how to use external filesystems to store big assets.\n\nIf you're using Laravel you're going to love this. If you use another framework, come along for the ride and steal some ideas.",
        ]);

        Video::create([
            'title' => 'Getting started with event sourcing in Laravel',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9tbxl_I1EGE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "In an event sourced app you're storing each event that happens within your app and derive all state from those events.\n\nIn this practical talk you'll get an intro on what event sourcing is and what the benefits are. After that we'll dive in the Laravel ecosystem and take a look at how we can create projectors and aggregates using the laravel-event-projector package.",
        ]);

        Video::create([
            'title' => 'Supercharging common controllers',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/supercharging-controllers" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => "A while ago I had to create a fairly complicated CRUD interface from scratch. While this isn't rocket science, there surprisingly aren't that many good resources out there on how to do this. That's why our team dove in and published a couple of packages that can help create modern CRUD interfaces.\n\nIn this highly practical talk you'll learn how we nowadays go about creating a CRUD interface at Spatie. We'll take a look at how we can convert url parameters to an Eloquent query. You'll learn what view models are. We'll create some server side components with BladeX and much more.",
        ]);
    }
}
