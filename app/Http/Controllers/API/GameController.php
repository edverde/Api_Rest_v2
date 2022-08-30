<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
   
    public function rollDice($id) 
    {
        if (!User::find($id)) {
            return response([
                "message" => "Unregistred User."], 404);
        } else{
       
            $dice1 = rand(1,6);
            $dice2 = rand(1,6);
            $total = $dice1 + $dice2;
            
            
        
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
    }
    

    public function delete($id)
    {   

        if (!User::find($id)) {
            return response([
                "message" => "Unregistred User."], 404);
        } else{

            $idUser = Game::where('user_id', '=', $id)->first('id');
            $userName = user::find($id)->name;

            if($idUser !== null){
                Game::where('user_id', $id)->delete();
                return response([
                    "message" => "User $userName's moves have been deleted."], 200);
            }elseif($idUser == null){
            return response([
                "message" => "User $userName has no moves to delete"], 422);

            }
        }
    }

    public function show($id){
        

        if (!User::find($id)) {
            return response([
                "message" => "Unregistred User."], 404);
        } else{

            $idUser = Game::where('user_id', '=', $id)->first('id');
            $userName = user::find($id)->name;

            if($idUser !== null){
                $moves = Game::where('user_id', $id)->get();
                return response([
                    "message" => "User $userName's moves are: ",
                    "moves"=> $moves
                ], 200);
            }elseif($idUser == null){
            return response([
                "message" => "User $userName has no moves to show."], 422);

            }
        }
    }

    public function ranking(){

        $ranking = DB::table('games')        
        ->join('users', 'games.user_id', '=', 'users.id')
        ->selectRaw('users.name as Player, 
         count(games.result) as Total_Plays,
         sum(games.result = 1) as Win_Games, 
         concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Triumph')  
        ->orderby('Triumph', 'desc')
        ->groupby('Player')
        ->get();

        return  $ranking;
        
    }
    
    public function loser(){
        $loser = DB::table('games')
        ->join('users','games.user_id','=','users.id')
        ->selectRaw('users.name as Player, 
         count(games.result) as Total_Plays,
         sum(games.result = 1) as Win_Games, 
         concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Triumph')  
        ->orderby('Triumph')
        ->groupby('Player')
        ->limit(1)
        ->get();

        return $loser;
    }

    public function winner(){
        $winner = DB::table('games')
        ->join('users','games.user_id','=','users.id')
        ->selectRaw('users.name as Player, 
         count(games.result) as Total_Plays,
         sum(games.result = 1) as Win_Games, 
         concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Triumph')  
        ->orderby('Triumph', 'desc')
        ->groupby('Player')
        ->limit(1)
        ->get();

        return $winner;
    }

    public function top5(){
        $top5 = DB::table('games')
        ->join('users','games.user_id','=','users.id')
        ->selectRaw('users.name as Player, 
         count(games.result) as Total_Plays,
         sum(games.result = 1) as Win_Games, 
         concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Triumph')  
        ->orderby('Triumph', 'desc')
        ->groupby('Player')
        ->limit(5)
        ->get();

        return $top5;
    }

    public function successRate(){
        $successRate = DB::table('games')
        ->join('users','games.user_id','=','users.id')
        ->selectRaw('users.name as Player, 
         count(games.result) as Total_Plays,
         sum(games.result = 1) as Win_Games, 
         concat(round(sum(games.result = 1)*100/count(games.result)),"%") as Triumph')         
       ->groupBy('users.name')
       ->get();

       return $successRate;
    }     
}      
       

        
        
    
