<?php

return [
    [
        'name' => 'main',
        'urls' => [
            '/',
        ],
    ],
    [
        'name' => 'list',
        'urls' => [
            '/listPage',
            '/services',
            '/articles',
        ],
    ],
    [
        'name' => 'list.item',
        'urls' => [
            '/listPage/item',
            '/services/(.*?)/?(^.*)',
            '/articles/(.*?)',
        ],
    ],
    [
        'name' => 'list.item.uniquePage',
        'urls' => [
            '/listPage/item/unique',
            '/services/(.*?)/unique',
            '/articles/(.*?)/unique',
        ],
    ],
    [
        'name' => '',
        'urls' => [
            '/passValue'
        ],
    ]
];