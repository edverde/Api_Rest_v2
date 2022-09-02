<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dice1 = rand(1,6);
            $dice2 = rand(1,6);
            $total = $dice1 + $dice2;
        
            if($total == 7) 
            {
                $result = 1;
                $print_result = 'WIN';
            }else 
            {
                $result = 0;
                $print_result = 'LOSE';
            }

        return [
            'dice1' => $dice1,
            'dice2' => $dice2,
            'result' => $result,
            'print_result' => $print_result,
            'user_id' => User::all()->random()->id
        ];
    }
}