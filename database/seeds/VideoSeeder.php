<?php

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        Video::create([
            'title' => 'Building a realtime dashboard with Laravel, Vue and Pusher',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jtB_rTh61Zo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'text' => 'On the wall mounted TV in our office a dashboard is displayed. At a glance we can see what the current tasks for each member of our team are, which important events are coming up, which music is playing, ... and much more.

In this talk I explain how we leveraged both Laravel and Vue to build the dashboard. After demonstrating the dashboard itself we take a deep dive in the code. We take a look at the entire flow: the grid system, how events are broadcasted using Pusher, some cool Vue mixins and much more. After this talk you\'ll be able to setup your own dashboard using our open sourced code.'
        ]);
    }
}
