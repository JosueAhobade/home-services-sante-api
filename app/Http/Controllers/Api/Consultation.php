<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\consultation as consult;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CreateConsultRequest;
use App\Http\Requests\EditConsultRequest;

class Consultation extends Controller
{

    public function index(Request $request){
        try{
            $query = consult::query();
            $perpage = 2;
            $page = $request->input('page', 1);
            $search = $request->input('search');
            if($search){
                $query->whereRaw("motif LIKE '%". $search."%'");
            }
            $total = $query->count();

            $result = $query->offset(($page - 1) *$perpage)->limit($perpage)->get();


            return response()->json([
                'status_code' => 200,
                'status_message' => 'Liste des  consultations ',
                'current_page' => $page,
                'last_page' => ceil( $total / $perpage),
                'items' =>$result,
            ]);
        } catch(Exception $e){
            return response()->json($e);
        }
    }
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

