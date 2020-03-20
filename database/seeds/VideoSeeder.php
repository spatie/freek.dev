<?php

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        Video::create([
            'title' => 'Taking care of backups with Laravel',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/fORNQ06K8LY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => '<p>Thanks to all the excellent resources on server management many developers are now setting up and administrating their own servers. If you are one of them you can\'t count on anybody else but yourself to backup the data of your clients.</p>

<p>We cover the backup issues presented when using modern hosting such as Linode and DigitalOcean. Then we review some enterprise grade solutions. Finally we dive deep into implementing a backup system using Laravel 5\'s filesystem abstraction.</p>',
        ]);

        Video::create([
            'title' => 'Building a realtime dashboard with Laravel, Vue and Pusher',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jtB_rTh61Zo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => '<p>On the wall mounted TV in our office a dashboard is displayed. At a glance we can see what the current tasks for each member of our team are, which important events are coming up, which music is playing, ... and much more.</p>
<p>In this talk I explain how we leveraged both Laravel and Vue to build the dashboard. After demonstrating the dashboard itself we take a deep dive in the code. We take a look at the entire flow: the grid system, how events are broadcasted using Pusher, some cool Vue mixins and much more. After this talk you\'ll be able to setup your own dashboard using our open sourced code.</p>',
        ]);

        Video::create([
            'title' => 'Handling media in a Laravel application',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ho9OVdxpFRM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => '<p>In most CMS kind of projects you\'re going to let a user upload all sorts of images and files. Storing those files, associating them with models, creating thumbnails for them, optimizing images, can be a lot of work. Luckily laravel-medialibrary can do all that for you.</p>

<p>In this talk you\'ll see a practical demo of how to get started with the medialibrary. You\'ll learn how to store files, generate urls to them, how to use different image profiles and how to use external filesystems to store big assets.</p>
<p>
If you’re using Laravel you’re going to love this. If you use another framework, come along for the ride and steal some ideas.</p>',
        ]);

        Video::create([
            'title' => 'Getting started with event sourcing in Laravel',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9tbxl_I1EGE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => '<p>In an event sourced app you\'re storing each event that happens within your app and derive all state from those events.</p>
<p>
In this practical talk you\'ll get an intro on what event sourcing is and what the benefits are. After that we\'ll dive in the Laravel ecosystem and take a look at how we can create projectors and aggregates using the laravel-event-projector package.</p>',
        ]);
    }
}
