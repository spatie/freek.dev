<?php

namespace App\Http\Controllers;

class MusicController
{
    public function __invoke()
    {
dd('stop');
        $releases = [
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

        return view('front.music.index', compact('releases'));
    }
}
