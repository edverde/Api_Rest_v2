<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request){
        $loginData =$request->validate([
            'email'=> 'email|required',
            'password' => 'required'
        ]);
        if(!Auth()->attempt($loginData)){
            return response(['message' => 'Invalid credentials','status' => 401]);
        }
            $user = $request->user();
            $accessToken = $user->createToken('authTestToken')->accessToken;

            return response([
                'user'=> Auth::user(),
                'access_token'=> $accessToken,
                'status' => 200
            ]);
    
        
    }
}