<?php

namespace Database\Seeders;
use App\Models\Game;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        Game::factory(100)->create();

        // Roles y permisos
        // Usuarios base
        // \App\Models\User::factory(10)->create();
    }
}