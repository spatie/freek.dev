<?php

namespace App\Http\Controllers\Discovery;

use Illuminate\View\View;
use function view;

class MusicController
{
    public function __invoke(): View
    {
        $releases['taxShelter'] = [
            [
                'title' => 'Beach Architecture',
                'artwork' => 'beach-architecture.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/0XE1YrUaxmE6Dy09MqY4Iu',
                    'Apple Music' => 'https://music.apple.com/be/album/beach-architecture/1700522501',
                ],
            ],
        ];

        $releases['kobus'] = [
            [
                'title' => 'Current',
                'artwork' => 'current.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/68bU6hpKZDmazUVqlWRGc2',
                    'Apple Music' => 'https://music.apple.com/be/album/current/1661027110',
                ],
            ],
            [
                'title' => 'Wave',
                'artwork' => 'wave.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/7tMcx25fPgkty5rnTnptd7',
                    'Apple Music' => 'https://music.apple.com/be/album/wave/1650479121',
                ],
            ],
            [
                'title' => 'Audience',
                'artwork' => 'audience.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/7g7GAi4AFxQHV6x0j14D7g',
                    'Apple Music' => 'https://music.apple.com/be/album/audience-ep/1629981840',
                ],
            ],
            [
                'title' => 'Draw',
                'artwork' => 'draw.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/1yCx7EPuWaZnQdtMu501JQ',
                    'Apple Music' => 'https://music.apple.com/be/album/draw/1529052246',
                ],
            ],
            [
                'title' => 'Second',
                'artwork' => 'second.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/1AxevyUP5d4pRVEgqmML72',
                    'Apple Music' => 'https://music.apple.com/be/album/second-ep/1531424129',
                ],
            ],
            [
                'title' => 'Left',
                'artwork' => 'left.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/03WFNNWoiNHOxMntno8EG3',
                    'Apple Music' => 'https://music.apple.com/be/album/left-ep/1542815899',
                ],
            ],
        ];

        $releases['topologies'] = [
            [
                'title' => 'Silve',
                'artwork' => 'silve.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/4qHt2PkVl7vbJt3xe8XaxG',
                    'Apple Music' => 'https://music.apple.com/be/album/topologies-ep/1659961230',
                ],
            ],
        ];

        $releases['jarenduren'] = [
            [
                'title' => '5+9',
                'artwork' => '59.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/43qIwN1wzYJGRYBRndQXwI',
                    'Apple Music' => 'https://music.apple.com/be/album/5-9-single/1563513563',
                ],
            ],
            [
                'title' => '3+2',
                'artwork' => '32.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/1CjaSyMReZycwLidhtyVSA',
                    'Apple Music' => 'https://music.apple.com/be/album/3-2-ep/1563510697',
                ],
            ],
            [
                'title' => 'D+R',
                'artwork' => 'dr.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/album/6voFOEd5gEwo2Fjeo28iV2',
                    'Apple Music' => 'https://music.apple.com/be/album/d-r-ep/1563562003',
                ],
            ],
        ];

        return view('front.music.index', compact('releases'));
    }
}
