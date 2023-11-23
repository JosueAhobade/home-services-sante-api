<?php

namespace App\Http\Controllers\Api;

use App\Customs\Services\EmailVerificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\LogUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;

class UserController extends Controller
{

    public function __construct(private EmailVerificationService $service){}


    public function register(RegisterUser $request){

        try{
            $user = new User([
                "email" => $request->email,
                "numero" => $request->numero,
                "password" => $request->password,
            ]);
            $user->save();
            if($user){
                $token = auth()->login($user);
                $this->service->sendVerificationLink($user);

                $patient = new Patient([
                    "nom" => $request->nom,
                    "prenom" => $request->prenom,
                    "sexe" => $request->sexe,
                    "age" => $request->age,
                    "userId" => $user->id,
                ]);
                $patient->save();

                $result = User::join('patients','patients.userId','=','users.id')
                        ->where('users.id',$user->id)
                        ->select('users.*','patients.*')
                        ->get();
                event( new Registered($user));

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Enrégistrement effectué avec succès ',
                    'user' => $result,
                ]);
            }
         }
            catch(Exception $e){
            return response()->json($e);
        }

    }

    public function login(LogUserRequest $request){
        if(auth()->attempt($request->only(['email','password']))){
            $user = auth()->user();
            $token = $user->createToken('MA_CLE_SECRET_UNIQUEMENT_VISIBLE_AU_BACKEND')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté',
                'user' => $user,
                'token' => $token
            ]);
        } else{


            return response()->json([
                'status_code' => 403,
                'status_message' => 'Informations non valide ',
            ]);
        }
    }
}
