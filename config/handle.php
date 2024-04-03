<?php

return [
    'role' => [
        'admin' => 1,
        'staff' => 2,
    ],

    'first_login' => [
        'true'  => 0,
        'false' => 1,
    ],

    'paginate' => 10,

    'http_code' => [
        'success' => 200,
        'error'   => 400,
    ],

    'qr_size' => [
        '110' => 110,
        '170' => 170
    ],

    'gender' => [
        'male'   => 1,
        'female' => 2,
        'other'  => 3
    ],

    'is_member'   => [
        'guest'  => 1,
        'member' => 2
    ],
    'member_code' => [
        'code_auto' => 5,
        'code_pad'  => '0'
    ],
    'type_date'   => [
        'day'   => 1,
        'month' => 2
    ],
    'type_age'    => [
        'under18' => 1,
        'upper19' => 2
    ],

    'remember_token' => [
        'uncheck' => 0,
        'checked' => 1,
    ],

    'start_list' => 0,

    'example_admin' => 1,
];