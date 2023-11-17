<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\consultation as consult;
use Exception;
use App\Http\Requests\CreateConsultRequest;
use App\Http\Requests\EditConsultRequest;

class Consultation extends Controller
{
    public function store(CreateConsultRequest $request) {

       try{
        $consult = new consult([
            'motif'=> $request->motif,
            'date_consultation'=>now(),
            'patientId'=>$request->patientId,
            'medecinId'=>$request->medecinId,
            'status'=>$request->status,
            'rapport'=>$request->rapport,
        ]);
        $consult->save();

         return response()->json([
            'status_code' => 200,
            'status_message' => 'Le consultation a été ajoutée',
            'data' =>$consult
        ]);
       } catch(Exception $e){
            return response()->json($e);
       }
    }

    public function update(EditConsultRequest $request, consult $consult){



        try{
            $consult->motif = $request->motif;

            $consult->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le consultation a été modifiée',
                'data' =>$consult
            ]);
        } catch(Exception $e){
            return response()->json($e);
        }
    }
}

