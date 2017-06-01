<?php

/*
 * This file is part of Laravel Vimeo.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'client_id' => 'd35a68622e07526a85789e2a867859cfdf5f3029',
            'client_secret' => '7rP0aNwz9BIn/hjGXGNsDBZM/ujNBqlwv04aD9TGh/wcwKAGmecFZxInvJpipCMHWGJDdXkQR+VqYuQeMycfbFcpySgmR+1Kgb3c600kjS8pLB9/QtcOmGacJphFWSfJ',
            'access_token' => 'a115d6301fbfc9653536c71cfbd491b4',
        ],

        'alternative' => [
            'client_id' => 'your-client-id',
            'client_secret' => 'your-client-secret',
            'access_token' => null,
        ],

    ],

];
