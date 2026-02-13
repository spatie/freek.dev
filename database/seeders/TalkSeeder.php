<?php

namespace Database\Seeders;

use App\Models\Talk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TalkSeeder extends Seeder
{
    public function run(): void
    {
        $this->getTalks()->each(function (array $talkAttributes) {
            Talk::create($talkAttributes);
        });
    }

    public function getTalks(): Collection
    {
        return collect([
            [
                'title' => 'Proven Package Patterns',
                'location' => 'Laracon India, Ahmedabad',
                'presented_at' => '2026-01-31',
            ],
            [
                'title' => 'Proven Package Patterns',
                'location' => 'Laravel Denmark Meetup, Aalborg',
                'presented_at' => '2025-11-13',
            ],
            [
                'title' => 'Uncharted Packages',
                'location' => 'Laravel Day, Verona, Italy',
                'presented_at' => '2025-11-20',
            ],
            [
                'title' => 'Uncharted Packages',
                'location' => 'Laracon US 2024',
                'presented_at' => '2024-08-27',
                'video_link' => 'https://www.youtube.com/watch?v=uncharted',
            ],
            [
                'title' => 'Uncharted Packages',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2024-02-07',
            ],
            [
                'title' => 'Using AI in products and Open Source',
                'location' => 'Spatie HQ, Antwerp, Belgium',
                'presented_at' => '2025-09-25',
            ],
            [
                'title' => 'Implementing Multitenancy in Laravel',
                'location' => 'Laracon India 2025',
                'presented_at' => '2025-08-03',
                'video_link' => 'https://www.youtube.com/watch?v=JmEmrLtMB_A',
            ],
            [
                'title' => 'Implementing Multitenancy in Laravel',
                'location' => 'Spatie, Antwerp',
                'presented_at' => '2025-03-27',
            ],
            [
                'title' => 'From Ignition to Flare',
                'location' => 'Laracon India',
                'presented_at' => '2024-03-24',
            ],
            [
                'title' => 'Fantastic functions and where to find them',
                'location' => 'PHPUKConference, London',
                'presented_at' => '2024-02-15',
                'video_link' => 'https://www.youtube.com/watch?v=ZWcgx0c2nGs',
            ],
            [
                'title' => 'Fantastic functions and where to find them',
                'location' => 'Laracon EU, Amsterdam, Netherlands',
                'presented_at' => '2022-04-26',
            ],
            [
                'title' => 'Introducing Laravel Data',
                'location' => 'Laracon US, Nashville, USA',
                'presented_at' => '2023-07-27',
                'video_link' => 'https://www.youtube.com/watch?v=CrO_7Df1cBc',
            ],
            [
                'title' => 'Building a Laravel package from scratch',
                'location' => 'Laracon EU, Lisbon',
                'presented_at' => '2023-01-26',
            ],
            [
                'title' => 'I Shall Define This Only Once',
                'location' => 'Laracon Online Summer 2022',
                'presented_at' => '2022-09-15',
                'slides_link' => 'https://speakerdeck.com/freekmurze/i-shall-define-this-only-once',
            ],
            [
                'title' => 'Building a Realtime Dashboard Powered by Laravel and Livewire',
                'location' => 'Laracon EU Online',
                'presented_at' => '2020-05-28',
                'video_link' => 'https://youtu.be/q7W2QW0UL8w?t=125',
                'slides_link' => 'https://speakerdeck.com/freekmurze/building-a-realtime-dashboard-with-laravel-livewire-phpkonf',
            ],
            [
                'title' => 'Introducing Ignition and Flare',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2019-08-30',
                'video_link' => 'https://freek.dev/1443-watch-the-flare-reveal-live',
                'slides_link' => 'https://speakerdeck.com/freekmurze/introducing-ignition-and-flare',
            ],
            [
                'title' => 'Supercharging common controllers',
                'location' => 'Laracon US',
                'presented_at' => '2019-07-24',
                'slides_link' => 'https://speakerdeck.com/freekmurze/talk-at-laracon-us',
            ],
            [
                'title' => 'Getting started with event sourcing in Laravel',
                'location' => 'Laracon Online',
                'presented_at' => '2019-03-06',
                'slides_link' => 'https://speakerdeck.com/freekmurze/event-sourcing-laracon-online',
            ],
            [
                'title' => 'Handling media in a Laravel application',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2018-09-03',
                'video_link' => 'https://www.youtube.com/watch?v=Ho9OVdxpFRM',
                'slides_link' => 'https://speakerdeck.com/freekmurze/handling-media-in-a-laravel-app-laracon-eu',
            ],
            [
                'title' => 'Handling media in a Laravel application',
                'location' => 'Laracon US, Chicago',
                'presented_at' => '2018-08-25',
                'video_link' => 'https://www.youtube.com/watch?v=3eyftAR5ilo',
                'slides_link' => 'https://speakerdeck.com/freekmurze/handling-media-in-a-laravel-app-laracon-us',
            ],
            [
                'title' => 'Creating a dashboard using Laravel, Vue and Pusher',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2017-08-30',
                'video_link' => 'https://www.youtube.com/watch?v=jtB_rTh61Zo',
                'slides_link' => 'https://speakerdeck.com/freekmurze/dashboard-laraconeu',
            ],
            [
                'title' => 'Creating a dashboard using Laravel, Vue and Pusher',
                'location' => 'Laracon US, New York',
                'presented_at' => '2017-07-25',
                'video_link' => 'https://streamacon.com/video/laracon-us-2017/day-1-freek-van-der-herten',
                'slides_link' => 'https://speakerdeck.com/freekmurze/dashboard-laraconus',
            ],
            [
                'title' => 'Taking care of backups with Laravel',
                'location' => 'Laracon EU, Amsterdam',
                'presented_at' => '2016-08-24',
                'video_link' => 'https://www.youtube.com/watch?v=fORNQ06K8LY',
                'slides_link' => 'https://speakerdeck.com/freekmurze/backing-up-with-laravel-laracon',
                'joindin_link' => 'https://joind.in/event/laracon-eu-2016/taking-car-of-backups-with-laravel',
            ],
            [
                'title' => 'Taking care of backups with Laravel',
                'location' => 'PHP UK Conference, London',
                'presented_at' => '2017-02-17',
                'video_link' => 'https://www.youtube.com/watch?v=klPNJypmIWQ',
                'slides_link' => 'https://speakerdeck.com/freekmurze/backing-up-with-laravel-phpuk',
                'joindin_link' => 'https://joind.in/event/php-uk-2017/taking-care-of-backups-with-laravel',
            ],
        ]);
    }
}
