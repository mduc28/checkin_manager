<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permission[] = Permission::create(['name' => 'create user']);
        $permission[] = Permission::create(['name' => 'edit user']);
        $permission[] = Permission::create(['name' => 'delete user']);
        $permission[] = Permission::create(['name' => 'show user']);
        $permission[] = Permission::create(['name' => 'create member']);
        $permission[] = Permission::create(['name' => 'edit member']);
        $permission[] = Permission::create(['name' => 'delete member']);
        $permission[] = Permission::create(['name' => 'show member']);
        $permission[] = Permission::create(['name' => 'show checkin']);
        $permission[] = Permission::create(['name' => 'create checkin']);
        $permission[] = Permission::create(['name' => 'show dashboard']);

        // create roles and assign existing permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo($permission);

        $roleUser = Role::create(['name' => 'staff']);
        $roleUser->givePermissionTo([
            'create member', 'edit member', 'delete member', 'show member', 'create checkin'
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin',
            'email' => 'admin@example.com',
            'phone' => '0987654321',
            'password' => bcrypt(123456),
            'role_id' => 1,
        ]);
        $user->assignRole($roleAdmin);

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example Staff',
            'email' => 'staff@example.com',
            'phone' => '0987654321',
            'password' => bcrypt(123456),
            'role_id' => 2,
        ]);
        $user->assignRole($roleUser);
    }
}
