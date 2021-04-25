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
                'title' => 'Corporate Melodies #2: My Opel Cors',
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
