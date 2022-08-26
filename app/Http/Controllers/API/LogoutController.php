<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use laravel\Passport\Passport;
use App\Models\User;


class LogoutController extends Controller
{
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            "message" => 'You have closed the session',
            'status' => 200
        ]);
    }
}