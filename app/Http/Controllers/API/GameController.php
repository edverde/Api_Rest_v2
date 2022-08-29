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
    // static $throws = 0;
    public function rollDice($id) 
    {
       
            $dice1 = rand(1,6);
            $dice2 = rand(1,6);
            $total = $dice1 + $dice2;
            // self::$throws+=1;
            
        
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
            return response(["message" => "YOU WIN! The sum of the two dice is:  $total."]);
        } else {

            return response(["message" => "YOU LOSE! The sum of the two dice is:  $total."]);
            }
        } 

    

    public function delete($id)
    {
        $idUser = Game::where('user_id', '=', $id)->first('id');
        $userName = user::find($id)->name;

        if($idUser !== null){
            Game::where('user_id', $id)->delete();
            return response([
                "message" => "borrado."], 200);
        }elseif($idUser == null){
        return response([
            "message" => "no hay nada que borrar"], 200);

        }
        
        // Game::where('user_id', $id)->delete();
        
        // return response([
        //     "message" => "Las jugadas del usuario $userName han sido eliminadas del sistema."], 200);
       







        // $userName = User::find($id)->name;
        // $idUser = DB::table('games')->where('user_id', '=', $id);

        // if(!User::find($id)){

        //         return response(["message" => "Unregistered user."], 422);
            
        //     }elseif($idUser->first('id') == null){

        //         return response()->json([
        //         "message" =>  "User $userName has no moves to delete.",
        //         ]);
        
        
        //     }else{
        //     $idUser->delete();
        //         return response()->json([
        //         "message" =>  "User $userName's moves have been deleted.",
        //     ]);
        // }
    }
        
}      
       

        
        
    
