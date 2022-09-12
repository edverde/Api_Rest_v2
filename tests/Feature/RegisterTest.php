<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */

    public function test_register_user_on_database() 
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', $user->toArray());
    }

     /** @test */

    public function test_register_user_status_ok() 
    {
        $this->artisan('passport:install');
        $data_user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            ];
        $response = $this->post('/api/players', $data_user);
        $response->assertStatus(201);
    }

     /** @test */    

    public function test_register_user_with_empty_email() 
    {
        $this->artisan('passport:install');
        $data_user = [
            'name' => 'test',
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            ];
        $response = $this->postJson('/api/players', $data_user);
        $response->assertStatus(422);
    }

     /** @test */

    public function test_register_user_with_empty_password() 
    {
        $this->artisan('passport:install');
        $data_user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '',
            'password_confirmation' => '',
            ];
        $response = $this->postJson('/api/players', $data_user);
        $response->assertStatus(422);
    }

     /** @test */

    
    public function test_register_user_with_wrong_password_confirmation() 
    {
        $this->artisan('passport:install');
        $data_user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345687',
            'role' => 0];
        $response = $this->postJson('/api/players', $data_user);
        $response->assertStatus(422);
    }
}