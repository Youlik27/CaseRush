<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = ['change users data', 'section and case management', 'open cases', 'view posts'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $moderatorRole = Role::create(['name' => 'moderator']);

        $adminRole->givePermissionTo('change users data');
        $moderatorRole->givePermissionTo('section and case management');
        $userRole->givePermissionTo('open cases');
    }
}

