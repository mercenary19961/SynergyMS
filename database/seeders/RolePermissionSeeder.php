<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the permissions
        $permissions = [
            // Employee management
            'manage employees',
            'create employees',
            'view employees',
            'edit employees',
            'delete employees',

            // Attendance management
            'manage attendance',
            'create attendance',
            'view attendance',
            'edit attendance',
            'delete attendance',

            // Project manager management
            'manage project managers',
            'view project managers',
            'edit project managers',
            'delete project managers',

            // Client management
            'manage clients',
            'create clients',
            'view clients',
            'edit clients',
            'delete clients',

            // General permissions
            'view dashboard',
            'create projects',
            'view projects',
            'edit projects',
            'delete projects',
            'create tickets',
            'view tickets',
            'edit tickets',
            'delete tickets',
            'view profile',
            'edit profile'
        ];

        // Create the permissions in the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to Super Admin
        $superAdminRole = Role::findByName('Super Admin');
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to Client
        $clientRole = Role::findByName('Client');
        $clientRole->givePermissionTo([
            'view dashboard',
            'view projects',
            'create projects',
        ]);

        // Assign specific permissions to Project Manager
        $projectManagerRole = Role::findByName('Project Manager');
        $projectManagerRole->givePermissionTo([
            'view dashboard',
            'create projects',
            'view projects',
            'edit projects',
            'delete projects',
            'create tickets',
            'view tickets',
            'edit tickets',
            'delete tickets',
        ]);

        // Assign specific permissions to HR
        $hrRole = Role::findByName('HR');
        $hrRole->givePermissionTo([
            'manage employees',
            'create employees',
            'view employees',
            'edit employees',
            'delete employees',
            'manage attendance',
            'create attendance',
            'view attendance',
            'edit attendance',
            'delete attendance',
            'manage project managers',
            'view project managers',
            'edit project managers',
            'delete project managers',
            'manage clients',
            'create clients',
            'view clients',
            'edit clients',
            'delete clients',
            'view dashboard',
        ]);

        // Assign specific permissions to Employee
        $employeeRole = Role::findByName('Employee');
        $employeeRole->givePermissionTo([
            'view profile',
            'edit profile',
            'view dashboard',
        ]);
    }
}
