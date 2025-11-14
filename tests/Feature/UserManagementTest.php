<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\EmployeeDetail;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\SpatieRolesSeeder']);
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\DepartmentSeeder']);
    }

    /** @test */
    public function authorized_user_can_create_client()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->post(route('admin.clients.store'), [
            'user_name' => 'Test Client',
            'user_email' => 'client@test.com',
            'user_password' => 'password123',
            'gender' => 'Male',
            'company_name' => 'Test Company',
            'industry' => 'Technology',
            'contact_number' => '+1234567890',
            'address' => '123 Test St',
            'website' => 'https://test.com',
        ]);

        $response->assertRedirect(route('admin.clients.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'client@test.com',
            'name' => 'Test Client',
        ]);

        $this->assertDatabaseHas('clients', [
            'company_name' => 'Test Company',
            'industry' => 'Technology',
        ]);
    }

    /** @test */
    public function client_creation_assigns_correct_role()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $this->actingAs($admin)->post(route('admin.clients.store'), [
            'user_name' => 'Test Client',
            'user_email' => 'client@test.com',
            'user_password' => 'password123',
            'company_name' => 'Test Company',
            'industry' => 'Technology',
            'contact_number' => '+1234567890',
            'address' => '123 Test St',
        ]);

        $user = User::where('email', 'client@test.com')->first();
        $this->assertTrue($user->hasRole('Client'));
    }

    /** @test */
    public function client_creation_validates_required_fields()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->post(route('admin.clients.store'), []);

        $response->assertSessionHasErrors([
            'user_name',
            'user_email',
            'user_password',
            'company_name',
            'industry',
            'contact_number',
            'address',
        ]);
    }

    /** @test */
    public function authorized_user_can_create_employee()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $department = Department::first();
        $position = Position::create([
            'name' => 'Developer',
            'department_id' => $department->id,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.employees.store'), [
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'gender' => 'Male',
            'position_id' => $position->id,
            'salary' => 50000,
            'date_of_joining' => '2024-01-01',
            'address' => '123 Test St',
            'nationality' => 'American',
            'age' => 25,
            'date_of_birth' => '1999-01-01',
            'department_id' => $department->id,
            'phone' => '+1234567890',
        ]);

        $response->assertRedirect(route('admin.employees.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'employee@test.com',
            'name' => 'Test Employee',
        ]);

        $this->assertDatabaseHas('employee_details', [
            'salary' => 50000,
            'position_id' => $position->id,
        ]);
    }
}
