<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Eddie',
            'email' => 'eddie@gmail.com',
            'email_verified_at' => now(),
            'role' => 1,
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);
        
        $user->role('admin');

        

        User::factory(30)->create()->each(function($user) {
            $user->Role('user');
        });
    }
}
