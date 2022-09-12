<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test */
    
    public function test_authenticated_user_can_logout()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();        
        Passport::actingAs($user);

        $response = $this->postJson(route('logout'));
        $response->assertStatus(200);
    }
}
