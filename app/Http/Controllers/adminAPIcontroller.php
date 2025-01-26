<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\organizations;

use App\Models\elections;

use App\Models\User;

class adminAPIcontroller extends Controller
{
    public function realtime_card(){

        return response()->json([

            'data' => organizations::select('organization')->get()

        ]);

    }

    public function realtime_org_election(Request $request){


         $data = elections::select('election_title', 'tbl_year', 'status', 'department')
         ->where('department', $request->organization)
         ->get();

         if ($data->isEmpty()) {
             return response()->json([

                'response' => 2,
                'message' => 'no data found'

             ]);
         }

        return response()->json([

            'response' => 1,
            'data' => $data

        ]);

    }

    public function myaccount(Request $request){

        $data = user::where('id', $request->id)->first();

        return response()->json([

            'data' => $data

        ]);

    }


    public function checkIfstarted(Request $request){

        $exist = elections::where('status', 'started')
        ->where('department', $request->organization)
        ->exists();


        if (!$exist) {

            return response()->json([

                'response' => 2

            ]);

        }

        return response()->json([

            'response' => 1

        ]);


    }
}
