<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
         'course create',
            'course view global',
            'course edit global',
            'course view team',
            'course edit team',
            'course view assigned',
            'edit assigned',
            'assign team',
            'assign manager',
            'assign users',
            'view board'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teamLead = Role::create(['name' => 'lead']);
        $teamLead->givePermissionTo(['course view team', 'course edit team', 'course view assigned', 'assign users', 'view board','edit assigned']);

        $id = Role::create(['name' => 'id']);
        $id->givePermissionTo(['course view assigned', 'edit assigned', 'view board']);

        $sme = Role::create(['name' => 'sme']);
        $sme->givePermissionTo(['course view assigned', 'edit assigned', 'view board']);
    }
}
