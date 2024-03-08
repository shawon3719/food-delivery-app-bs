<?php
return [

    'Super Admin' => [
        'permission' => 
        [
            'user'                      => ['*'],
            'user_access'               => ['*'],
            'permission'                => ['*'],
            'role'                      => ['*'],
        ],
    ],
    'Admin' => [
        'permission' => 
        [
            'user_access'               => ['*'],
        ],
    ],
    'User' => [
        'permission' => 
        [
            'user_access'               => ['*'],
        ],
    ],
];