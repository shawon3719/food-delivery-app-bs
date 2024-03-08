<?php
return [
    'user' => [
        'display_name' => 'User',
        'actions' => [
            'create' 		=> 'user_create',
            'edit' 			=> 'user_edit',
            'view' 			=> 'user_show',
            'delete' 		=> 'user_delete',
            'log'           => 'user_log_access'
        ]
    ],
    'user_access' => [
        'display_name' => 'User Access',
        'actions'  => [
            'access' 		=> 'user_access',
			'management'	=> 'user_management_access',
        ]
    ],
    'permission' => [
        'display_name' => 'Permission',
        'actions' => [
            'create' 		=> 'permission_create',
            'edit' 			=> 'permission_edit',
            'view' 			=> 'permission_show',
            'delete' 		=> 'permission_delete',
            'access' 		=> 'permission_access'
        ]
    ],
	'role' => [
        'display_name' => 'Role',
        'actions' => [
            'create' 		=> 'role_create',
            'edit' 			=> 'role_edit',
            'view' 			=> 'role_show',
            'delete' 		=> 'role_delete',
            'access' 		=> 'role_access'
        ]
    ],
];