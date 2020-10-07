<?php

return [
    'steps' => [
        'database' => env('INSTALL_STEP_DATABASE', false),
        'mail' => env('INSTALL_STEP_MAIL', false),
        'finish' => env('INSTALL_STEP_FINISH', false)
    ],

    'requirements' => [
        'OpenSSL',
        'PDO',
        'Mbstring',
        'Tokenizer',
        'XML',
        'Ctype',
        'JSON',
        'Fileinfo',
        'Imagick'
    ]
];