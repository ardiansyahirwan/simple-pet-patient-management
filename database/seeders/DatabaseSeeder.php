<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit owner']);
        Permission::create(['name' => 'delete owner']);
        Permission::create(['name' => 'create owner']);
        Permission::create(['name' => 'edit patient']);
        Permission::create(['name' => 'delete patient']);
        Permission::create(['name' => 'create patient']);
        Permission::create(['name' => 'edit treatment']);
        Permission::create(['name' => 'delete treatment']);
        Permission::create(['name' => 'create treatment']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'create permission']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'user']);
        $role1->givePermissionTo('edit owner');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('create patient');
        $role2->givePermissionTo('edit patient');
        $role2->givePermissionTo('delete patient');
        $role2->givePermissionTo('create owner');
        $role2->givePermissionTo('edit owner');
        $role2->givePermissionTo('delete owner');
        $role2->givePermissionTo('create treatment');
        $role2->givePermissionTo('edit treatment');
        $role2->givePermissionTo('delete treatment');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@email.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@email.com',
        ]);
        $user->assignRole($role3);
    }
}
