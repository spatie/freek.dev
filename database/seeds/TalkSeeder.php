<?php

use App\Models\Talk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TalkSeeder extends Seeder
{
    public function run()
    {
        $this->getTalks()->each(function (array $talkAttributes) {
            Talk::create($talkAttributes);
        });
    }

    public function getTalks(): Collection
    {
        return collect([
            [
                'title' => 'Setting up your private packagist',
                'location' => 'PHP Antwerp',
                'presented_at' => '2015-07-01',
                'joindin_link' => 'https://joind.in/event/php-antwerp-july-meetup/set-up-your-own-packagist',
                'slides_link' => 'https://speakerdeck.com/freekmurze/set-up-your-own-packagist',
            ],
            [
                'title' => 'Why are we sponsering our local meetup group',
                'location' => 'PHP Antwerp',
                'presented_at' => '2016-01-27',
                'video_link' => 'https://youtu.be/j4nS_dGxxs8?t=52s'
            ],
            [
                'title' => 'Backing up with Laravel',
                'location' => 'Barcamp, Antwerp',
                'presented_at' => '2017-05-12',
            ],
            [
                'title' => 'The story behind our open source efforts',
                'location' => 'Eurostar Connect Ghent',
                'presented_at' => '2016-10-05',
                'slides_link' => 'https://speakerdeck.com/freekmurze/open-source-efforts'
            ],
            [
                'title' => 'Taking care of backups with Laravel',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2016-08-24',
                'slides_link' => 'https://speakerdeck.com/freekmurze/backing-up-with-laravel-laracon',
                'video_link' => 'https://www.youtube.com/watch?v=fORNQ06K8LY',
                'joindin_link' => 'https://joind.in/event/laracon-eu-2016/taking-car-of-backups-with-laravel',
            ],
            [
                'title' => 'Creating a dashboard with Laravel, Vue and Pusher',
                'location' => 'Laravel Brussels',
                'presented_at' => '2016-12-14',
            ],
            [
                'title' => 'The story behind our open source efforts',
                'location' => 'Laravel Brussels',
                'presented_at' => '2016-12-14',
                'slides_link' => 'https://speakerdeck.com/freekmurze/open-source-efforts',
            ],
            [
                'title' => 'Taking care of backups with Laravel',
                'location' => 'Laravel Toyo',
                'presented_at' => '2016-09-12',
                'slides_link' => 'https://speakerdeck.com/freekmurze/backing-up-with-laravel-tokyo',
            ],


        ]);
    }
}
