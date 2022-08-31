<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAll(){
        if (Auth::user()->role != "1") {
            return response()->json([
                'message' => 'Sorry but you are not allowed to realice this action.',
                
            ],403);
        } else {
            return User::all();
        }
       
        
    }  

    public function updateName(Request $request, $id)
    {
        $auth = Auth::user()->id;
        if (!User::find($id)) {
            return response([
                "message" => "User not found."
                    ], 404);
        }elseif ($auth == $id) {
        
            $user = User::find($id);
                
            $request->validate([
                'name' => 'max:20|unique:users,name,',
                'email' => 'email|max:255|unique:users,email,',   
            ]);
        
        }else {
            return response([
                "message" => "You are not authorized to perform this action."
                    ], 401);
        }

        $user->update($request->all());
        return $user;

    } 
         
        
    
}