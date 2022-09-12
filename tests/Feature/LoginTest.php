<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */

    public function test_user_can_login_with_correct_Credentials()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create(['password' => bcrypt($password = '12345678')]);

        $response = $this->post('api/login', ['email' => $user->email,'password' => $password]);
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */

    public function test_login_displays_validation_errors_email()
    {
        $response = $this->post('api/login', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */

    public function test_login_displays_validation_errors_password()
    {
        $response = $this->post('api/login', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }

    /** @test */

    public function test_email_is_required_when_login() 
    {
        $this->artisan('passport:install');
        $response = $this->post('api/login', ['email' => '','password' => '12345678']);
        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(302);
    }

    /** @test */

    public function test_password_is_required_when_login() 
    {
        $this->artisan('passport:install');
        $response = $this->post('api/login', ['email' => 'test@email.com','password' => '']);
        $response->assertSessionHasErrors(['password']);
        $response->assertStatus(302);
    }
}
