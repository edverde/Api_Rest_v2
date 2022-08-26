<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function rollDice($id) 
    {
        $authorization = Auth::user()->id;
        $throws = 0;
        static $totalthrows = 0;

        if (!User::find($id)) {
            return response(["message" => "Unregistered user."], 422);//La petición estaba bien formada pero no se pudo seguir debido a errores de semántica.
        } elseif ($authorization == $id) {
            $dice1 = rand(1,6);
            $dice2 = rand(1,6);
            $total = $dice1 + $dice2;
            $throws += 1;
            $totalthrows += 1;
        
        if ($total == 7) {
            $result = 1;
            
        } else {
            $result = 0;
          
        }

        Game::create([
            "dice1" => $dice1,
            "dice2" => $dice2,
            "result" => $result,
            "user_id" => $id
        ])
        ->where('user_id', '=', $id)
        ->get();

        if ($result == 1) {
            return response(["message" => "YOU WIN! <br> The sum of the two dice is:  $total  and you have throw $throws times."]);
        } else {

            return response(["message" => "YOU LOSE! <br> The sum of the two dice is:  $total  and you have throw $throws times."]);
            }
        } 
        
        
    }  
}