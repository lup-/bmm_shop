<?php

return [
    'utf_mode'           =>
        [
            'value'    => true,
            'readonly' => true,
        ],
    'cache'              => [
        'value' => [
            'type'     => 'memcache',
            'memcache' => [
                'host' => $_ENV['MEMCACHED_HOST'],
                'port' => '11211',
            ],
            'sid'      => $_SERVER["DOCUMENT_ROOT"] . "#01",
        ],
        'readonly' => false,
    ],
    'cache_flags'        =>
        [
            'value'    =>
                [
                    'config_options' => 3600.0,
                    'site_domain'    => 3600.0,
                ],
            'readonly' => false,
        ],
    'cookies'            =>
        [
            'value'    =>
                [
                    'secure'    => false,
                    'http_only' => true,
                ],
            'readonly' => false,
        ],
    'exception_handling' =>
        [
            'value'    =>
                [
                    'debug'                      => true,
                    'handled_errors_types'       => 4437,
                    'exception_errors_types'     => 4437,
                    'ignore_silence'             => false,
                    'assertion_throws_exception' => true,
                    'assertion_error_type'       => 256,
                    'log'                        => null,
                ],
            'readonly' => false,
        ],
    'connections'        =>
        [
            'value'    =>
                [
                    'default' =>
                        [
                            'className' => '\\Bitrix\\Main\\DB\\MysqliConnection',
                            'host'      => $_ENV['MYSQL_HOST'],
                            'database'  => $_ENV['MYSQL_DATABASE'],
                            'login'     => $_ENV['MYSQL_USER'],
                            'password'  => $_ENV['MYSQL_PASSWORD'],
                            'options'   => 2.0,
                        ],
                ],
            'readonly' => true,
        ],
    'crypto'             =>
        [
            'value'    =>
                [
                    'crypto_key' => 'b0ab38d7d1c25fc216a07ae654b8904b',
                ],
            'readonly' => true,
        ],
];
