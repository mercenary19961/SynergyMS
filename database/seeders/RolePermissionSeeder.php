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
            'manage users', 
            'create users', 
            'view users', 
            'edit users', 
            'delete users',
            'manage attendance', 
            'create attendance', 
            'view attendance', 
            'edit attendance', 
            'delete attendance',
            'manage departments', 
            'create departments', 
            'view departments', 
            'edit departments', 
            'delete departments',
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
