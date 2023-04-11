<?php

return [

    'services' => [

        'facebook' => [
            'name' => 'Facebook',
        ],

        'vkontakte' => [
            'name' => 'Vkontakte',
        ],

    ],

    'events' => [

        'facebook' => [
            'created' => \App\Events\Social\FacebookAccountWasLinked::class,
        ]

    ]

];