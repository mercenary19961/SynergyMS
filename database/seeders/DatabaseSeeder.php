<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SpatieRolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EmployeeDetailSeeder::class);
        $this->call(ProjectManagerSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(HumanResourcesSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(EventSeeder::class);
    }
}
