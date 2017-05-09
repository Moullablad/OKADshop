<?php
return [
    /* ---------------------------------------------------
     |  General
     | ---------------------------------------------------
     */
    'general' => [
        'title' => [
            'separator' => '-',
            'max' => '55',
            'position' => '0'
        ],
        'description' => [
            'max' => '155'
        ],
        'keywords' => [

        ],
        'misc' => [
            'canonical' => '1',
            'robots' => 'index, follow',
            'viewport' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no',
            'author' => '',
            'copyright' => '',
            'publisher' => ''
        ]
    ],

    /* ---------------------------------------------------
     |  Webmasters
     | ---------------------------------------------------
     */
    'webmasters' => [
        'google' => '',
        'client_id' => '',
        'bing' => '',
        'alexa' => '',
        'pinterest' => '',
        'yandex' => '',
    ],

    /* ---------------------------------------------------
     |  Open Graph
     | ---------------------------------------------------
     */
    'og' => [
        'enabled' => '1',
        // 'prefix' => 'og:',
        'type' => 'website',
        'image' => ''
    ],

    /* ---------------------------------------------------
     |  Twitter
     | ---------------------------------------------------
     */
    'twitter' => [
        'enabled' => '1',
        // 'prefix' => 'twitter:',
        'card' => 'summary',
        'site' => '',
        'image' => ''
    ],

    /* ---------------------------------------------------
     |  Analytics
     | ---------------------------------------------------
     */
    'analytics' => [
        'code' => ''
    ]

];