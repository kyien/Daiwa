<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Account
    |--------------------------------------------------------------------------
    |
    | This is the default account to be used when none is specified.
    */

    'default' => 'staging',

    /*
    |--------------------------------------------------------------------------
    | Native File Cache Location
    |--------------------------------------------------------------------------
    |
    | When using the Native Cache driver, this will be the relative directory
    | where the cache information will be stored.
    */

    'cache_location' => '../cache',

    /*
    |--------------------------------------------------------------------------
    | Accounts
    |--------------------------------------------------------------------------
    |
    | These are the accounts that can be used with the package. You can configure
    | as many as needed. Two have been setup for you.
    |
    | Sandbox: Determines whether to use the sandbox, Possible values: sandbox | production
    | Initiator: This is the username used to authenticate the transaction request
    | LNMO:
    |    paybill: Your paybill number
    |    shortcode: Your business shortcode
    |    passkey: The passkey for the paybill number
    |    callback: Endpoint that will be be queried on completion or failure of the transaction.
    |
    */

    'accounts' => [
        'staging' => [
            'sandbox' => true,
            'key' => 'sS0o4vOuzz3au0dPVFXh96LA96WUqPOo',
            'secret' => 'YxlZASVgcTRwMf3n',
            'initiator' => 'apitest363',
            'id_validation_callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            'lnmo' => [
                'paybill' => 174379,
                'shortcode' => 174379,
                'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'callback' => 'https://5c2ab351.ngrok.io/api/mpesa/confirm',
            ]
        ],

        'production' => [
            'sandbox' => false,
            'key' => 'zPQKRM3XgRxWfJDk0yrP5GQc0lvRlhna',
            'secret' => 'hnAHKAZmChQnuNUX',
            'initiator' => 'MDDAIWA',
            'id_validation_callback' => 'http://example.com/callback?secret=some_secret_hash_key',
            'lnmo' => [
                'paybill' => 759955,
                'shortcode' => 759955,
                'passkey' => '464c26b8414682630891a000921dba871ed5b300de1342e197d1ff2d4b801242',
                'callback' => 'https://20dc32ad.ngrok.io/api/mpesa/callback?secret=CDBD82EC6F89FF7CA76F5990196AAF6FD2A11A8A6D87F881F94E3076296059C5',
            ]
        ],
    ],
];
