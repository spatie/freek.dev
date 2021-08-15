<?php

namespace App\Http\Controllers;

class MusicController
{
    public function __invoke()
    {
        $releases['kobus'] = [
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

        $releases['corporateMelodies'] = [
            [
                'title' => 'Corporate Melodies #6: Can I Kick It?',
                'artwork' => 'cm006.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/0ky2gt77qwYyMnbSEJY5rp?si=ae9579e77804494a',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-6-can-i-kick-it/pl.u-bEJ7s9NWZa',
                ],
            ],
            [
                'title' => 'Corporate Melodies #5: Guilty Pleasures',
                'artwork' => 'cm005.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/3UiHWL9l95iu7LWtR7sQyq?si=e92944e2fed547e2',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-5-guilty-pleasures/pl.u-6YJ3tAmqbd',
                ],
            ],
            [
                'title' => 'Corporate Melodies #4: Acceptable in the 80s',
                'artwork' => 'cm004.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/5KX46Xr7RctbWKQSvJFwma?si=aff1158084214f58&nd=1',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-4-acceptable-in-the-80s/pl.u-bEZDC9NWZa',
                ],
            ],
            [
                'title' => 'Corporate Melodies #3: Belgian Wonders',
                'artwork' => 'cm003.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/6RoreKy23iKHj09TLfEoFr?si=c874a4fb0c2b4708',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-3-belgian-wonders/pl.u-RmZxCP6A24',
                ],
            ],
            [
                'title' => 'Corporate Melodies #2: My Opel Corsa',
                'artwork' => 'cm002.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/0rw7PsTmtm8PEfsF63lsF0',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-2-my-opel-corsa/pl.u-vmG3TYoaLr',
                ],
            ],
            [
                'title' => 'Corporate Melodies #1: Late Nite Something',
                'artwork' => 'cm001.jpg',
                'links' => [
                    'Spotify' => 'https://open.spotify.com/playlist/3PONMswLMDbeRdCEx4MOxO',
                    'Apple Music' => 'https://music.apple.com/be/playlist/corporate-melodies-1-late-night-something/pl.u-RmWDiP6A24',
                ],
            ],
        ];

        return view('front.music.index', compact('releases'));
    }
}
