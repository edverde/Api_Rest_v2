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
    public function index()
    {
        $users = DB::table('users')
        ->select('*')
        ->get();
    
        return response()->json(['users' => $users,'status' => 200]);
    }   

    public function updateName(Request $request, $id)
    {
        $authorization = Auth::user()->id;

        if (!User::find($id)) {
            return response([
                "message" => "Unregistered user."
                    ], 422); //La petición estaba bien formada pero no se pudo seguir debido a errores de semántica.
        } elseif ($authorization == $id) {
            $user = User::find($id);
            $request->validate([
                'nickname' => 'required|max:12|unique:users,nickname,'.$user->id,
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,   
            ]);
        } else {
            return response([
                "message" => "You are not authorized."
                    ], 401); //Es necesario autenticar para obtener la respuesta solicitada. Esta es similar a 403, pero en este caso, la autenticación es posible.
        }

        $user->update($request->all());
        return response($user, 200);

    }       
        
    
}