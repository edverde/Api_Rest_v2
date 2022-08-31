<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use laravel\Passport\Passport;
use App\Models\User;


class RegisterController extends Controller
{
    public function register(Request $request){
        
        if($request['name'] == null){
            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required'
            ]);
            
            $validatedData['name'] = 'Guest';

        }else{

            $validatedData = $request->validate([
            'name' => 'required|string|unique:users|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);
        }
        
        
        $validatedData['password'] = Hash::make($request->password);
        
        $user = User::create($validatedData);
       
        $accessToken = $user->createToken('authToken')->accessToken;
        
        return response([
            
            'user' => $user,
            'acess_token' => $accessToken
        ],201);
        
    }
}