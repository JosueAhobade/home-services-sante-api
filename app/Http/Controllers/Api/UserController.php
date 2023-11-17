<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\LogUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(RegisterUser $request){

        try{
            $user = new User();

            $user->email = $request->email;
            $user->numero = $request->numero;
            $user->password = $request->password;

            $user->save();


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Enrégistrement effectué avec succès ',
                'user' => $user,
            ]);
         }
            catch(Exception $e){
            return response()->json($e);
        }

    }

    public function login(LogUserRequest $request){

    }
}
