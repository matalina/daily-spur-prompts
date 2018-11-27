<?php
return [
    'wordpress' => [
        'to' => 'wuwu746kugo@post.wordpress.com',
        'from' => 'nox.durante@gmail.com',
    ],
    'unsplash' => [
        'access' => env('UNSPLASH_ACCESS_KEY'),
        'secret' => env('UNSPLASH_SECRET_KEY'),
        'name' => env('UNSPLASH_APP_NAME'),
    ],
    'spotify' => [
        'id' => env('SPOTIFY_CLIENT_ID'),
        'secret' => env('SPOTIFY_CLIENT_SECRET'),
        'uri' => '',
    ],
];