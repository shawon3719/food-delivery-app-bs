<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->name, 0, 5) != 'user_' && substr($permission->name, 0, 5) != 'role_' && substr($permission->name, 0, 11) != 'permission_' && substr($permission->name, 0, 17) != 'service_' && $permission->name != 'isp_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
        Role::findOrFail(3)->permissions()->sync($user_permissions);
    }
}
