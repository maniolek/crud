<?php
return [
    'mongo' => [
        'dbname' => 'vegas_test'
    ],
    'mysql' => [
        'host'     => "localhost",
        'dbname'   => "vegas_test",
        'port'     => 3306,
        'username' => "root",
        'password' => "root"
    ],
    'application' => [
        'baseUri' => '',
        'modules' => [
            'Test'
        ],
        'autoload' => [
            'App\Initializer' => TESTS_ROOT_DIR . '/fixtures/app/initializers',
            'App\Shared' => TESTS_ROOT_DIR . '/fixtures/app/shared',
            'App\View' => TESTS_ROOT_DIR . '/fixtures/app/view'
        ],
        'modulesDirectory' => APP_ROOT . '/app/modules',
        'sharedServices' => [
            'App\Shared\Mysql',
            'App\Shared\Mongo',
            'App\Shared\ViewCache'
        ],
        'initializers'=> [
            'App\Initializer\Volt',
            'App\Initializer\Crud'
        ],
        'view' => [
            'cacheDir' => TESTS_ROOT_DIR . '/fixtures/cache/view/',
            'viewsDir' => TESTS_ROOT_DIR . '/fixtures/app',
            'layout' => 'main',
            'layoutsDir' => 'layouts/',
            'engines' => [
                'volt' => [
                    'compiledPath' => TESTS_ROOT_DIR . '/fixtures/cache/view/compiled/',
                    'compiledSeparator' => '_',
                    'compileAlways' => false
                ]
            ]
        ]
    ]
];
