<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'name' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'name' => 'permission_create',
            ],
            [
                'id'    => 3,
                'name' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'name' => 'permission_show',
            ],
            [
                'id'    => 5,
                'name' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'name' => 'permission_access',
            ],
            [
                'id'    => 7,
                'name' => 'role_create',
            ],
            [
                'id'    => 8,
                'name' => 'role_edit',
            ],
            [
                'id'    => 9,
                'name' => 'role_show',
            ],
            [
                'id'    => 10,
                'name' => 'role_delete',
            ],
            [
                'id'    => 11,
                'name' => 'role_access',
            ],
            [
                'id'    => 12,
                'name' => 'user_create',
            ],
            [
                'id'    => 13,
                'name' => 'user_edit',
            ],
            [
                'id'    => 14,
                'name' => 'user_show',
            ],
            [
                'id'    => 15,
                'name' => 'user_delete',
            ],
            [
                'id'    => 16,
                'name' => 'user_access',
            ],
            [
                'id'    => 17,
                'name' => 'user_log_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
