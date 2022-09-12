<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */

    public function test_unauthenticated_user_cannot_list_all_players()
    {
        $response = $this->getJson('api/users');

        $response->assertStatus(401);
    }

    /** @test */

    public function test_admin_user_can_list_all_players()
    {
        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => "1"]);
        $admin = Passport::actingAs($admin);

        if ($admin['role'] == 1) {

            $response = $this->actingAs($admin, 'api')->getJson('api/users');
            $response->assertOk();
     
            $this->assertAuthenticated();
        }
    }

    /** @test */

    public function test_non_admin_user_cannot_list_all_players()
    {
        $this->artisan('passport:install');

        $response = $this->getJson('api/users');
        $user = User::factory()->create(['role' => "0"]);

        if ($user->role == 0) {
            
            $response->assertStatus(401);
            $response->assertUnauthorized();
        }
    }

    /** @test */

    public function test_player_name_can_be_updated() 
    {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $user = Passport::actingAs($user);
        $response = $this->actingAs($user, 'api')->put(route('updateName', $user->id),
        
        ['name' => 'topotamadre',
         'email' => 'topotamadre@email.com'  
        ]);

        $this->assertAuthenticated();

        $response->assertOk();

        $this->assertDatabaseHas('users', ['name' => 'topotamadre']);
    }
}
