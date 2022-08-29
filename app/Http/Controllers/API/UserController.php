<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAll(){
        return User::all();
    }  

    public function updateName(Request $request, $id)
    {
        
        
            $user = User::find($id);
                
            $request->validate([
                'name' => 'max:20|unique:users,name,',
                'email' => 'email|max:255|unique:users,email,',   
            ]);
          
        

        $user->update($request->all());
        return $user;

    } 
         
        
    
}