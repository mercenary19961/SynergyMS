<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create users',
            'view users',
            'edit users',
            'delete users',
            'manage users',
            
            'create roles & permissions',
            'view roles & permissions',
            'edit roles & permissions',
            'delete roles & permissions',

            'view dashboard',

            'create projects',
            'view projects',
            'edit projects',
            'delete projects',

            'create reports',
            'view reports',
            'edit reports',
            'delete reports',

            'create attendance',
            'view attendance',
            'edit attendance',
            'delete attendance',
            'manage attendance',

            'create departments',
            'view departments',
            'edit departments',
            'delete departments',
            'manage departments',

            'create tickets',
            'view tickets',
            'edit tickets',
            'delete tickets',
            

            'view profile',
            'edit profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
