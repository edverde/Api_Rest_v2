<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Laravel\Passport\Passport;
class GameTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */

    public function test_user_can_list_players_success_rate()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->getJson('api/players');
        $response->assertOk();
    }

    /** @test */

    public function test_unauthenticated_user_cannot_list_players_success_rate()
    {
        $response = $this->getJson(route('successRate')); 
        $response->assertStatus(401);
    }

    /**@test */

    public function test_user_can_roll_dice() 
    {
        // $this->withoutExceptionHandling();
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->postJson(route('rollDice', $user->id));
        $response->assertOk();
        $response->assertStatus(200);
    }

     /** @test */

    public function test_unauthenticated_user_cannot_roll_dice()
    {
        $response = $this->postJson('api/players/{id}/games');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_delete() 
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
        Game::factory()->create();
        
        $response = $this->actingAs($user, 'api')->deleteJson(route('delete', $user->id));
        $response->assertStatus(200);
    }

    /** @test */

    public function test_unauthenticated_user_cannot_delete_player_games()
    {
        $response = $this->deleteJson('api/players/{id}/games');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_show() {

        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);
        Game::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson(route('show',$user->id));
        $response->assertStatus(200);
    }

    /** @test */

    public function test_unauthenticated_user_cannot_show()
    {
        $response = $this->getJson('api/players/{id}/games');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_see_ranking() 
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->get(route('ranking'));
        $response->assertStatus(200);
    }

    /** @test */

    public function test_Unauthenticated_user_cannot_list_ranking()
    {
        $response = $this->getJson('api/players/ranking');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_see_loser() 
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->getJson(route('loser'));
        $response->assertOk();
    }

    /** @test */

    public function test_unauthenticated_user_cannot_list_loser()
    {
        $response = $this->getJson('api/players/ranking/loser');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_see_winner() 
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->getJson(route('winner'));
        $response->assertOk();
    }

    /** @test */

    public function test_unauthenticated_user_cannot_list_winner()
    {
        $response = $this->getJson('api/players/ranking/winner');
        $response->assertStatus(401);
    }

    /** @test */

    public function test_user_can_see_top5() 
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $user = Passport::actingAs($user);

        $response = $this->actingAs($user, 'api')->getJson(route('top5'));
        $response->assertOk();
    }

    /** @test */

    public function test_unauthenticated_user_cannot_list_top5()
    {
        $response = $this->getJson('api/players/ranking/top5');
        $response->assertStatus(401);
    }
}
