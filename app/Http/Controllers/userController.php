<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\votingcandidate;
use App\Models\ballot;
use App\Models\voters;
use Session;

class userController extends Controller
{
    public function submit_vote(Request $req)
    {
        $data = $req->all();

        unset($data["_token"]);

        $dataArray = [];

        foreach ($data as $key => $value) {
            $candidate = votingcandidate::where('id', $value)->first();

            if ($candidate) {
                // Increment the vote count
                $candidate->vote += 1;
                $candidate->save();

                // Add updated candidate data to the response array
                $model = new ballot;
                $model->fingerprint = Session::get('id');
                $model->voted_candidates = $value;
                $model->election_title = Session::get('election_title');
                $model->election_year = Session::get('election_year');
                $model->organization = Session::get('organization');
                $model->save();
                $dataArray[] = [
                    'id' => $candidate->id, 
                    'votes' => $candidate->vote,
                    'voted' => $value
                     ];
            } else {
                // If the candidate ID is not found
                $dataArray[] = ['id' => $value, 'message' => 'No candidate found'];
            }
        }

        // Return a JSON response with the updated data
        // return response()->json([
        //     'data' => $dataArray
        // ]);
        return back()->with([

            'response' => 1

        ]);
        // return response()->json([

        //     'data' => $data

        // ]);
    }

    public function update_data(Request $request){

        $data = $request->all();
        unset($data["_token"]);
        $update = voters::where('organization', Session::get('organization'))
        ->where('fingerprint', Session::get('user_fingerprint'))
        ->update($data);

        if (!$update) {
            
            return back()->with([

                'response' => 1

            ]);
            
        }

        return back()->with([

            'response' => 1

        ]);
    }
}
