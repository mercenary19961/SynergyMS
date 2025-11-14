<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable CSRF for testing
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Run migrations and seeders for permissions/roles
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\SpatieRolesSeeder']);
    }

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('Employee');

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect();
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_requires_email()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_requires_valid_email_format()
    {
        $response = $this->post('/login', [
            'email' => 'not-an-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_requires_password()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function login_requires_minimum_password_length()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '12345', // Less than 6 characters
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function login_is_rate_limited_after_multiple_attempts()
    {
        $this->withoutExceptionHandling();

        // Make 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be rate limited
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $user->assignRole('Employee');

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    /** @test */
    public function session_is_invalidated_on_logout()
    {
        $user = User::factory()->create();
        $user->assignRole('Employee');

        $this->actingAs($user);

        $sessionToken = session()->token();

        $this->post('/logout');

        // Session token should be regenerated
        $this->assertNotEquals($sessionToken, session()->token());
    }

    /** @test */
    public function super_admin_redirects_to_admin_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('Super Admin');

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function client_redirects_to_client_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'client@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('Client');

        $response = $this->post('/login', [
            'email' => 'client@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('client.dashboard'));
    }

    /** @test */
    public function employee_redirects_to_employee_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'employee@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('Employee');

        $response = $this->post('/login', [
            'email' => 'employee@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('employee.dashboard'));
    }
}
