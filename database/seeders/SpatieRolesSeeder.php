<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SpatieRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Client',
            'Project Manager',
            'HR',
            'Employee',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
