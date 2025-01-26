<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\votingcandidate;

use App\Models\votingcomponents;

use App\Models\elections;

use App\Models\ballot;
use App\Models\voters;

class userAPIcontroller extends Controller
{

    public function hasVoting(Request $request){

        $election = elections::where('department', $request->organization)
        ->where('status', 'started')
        ->exists();

        if (!$election) {
            return response()->json([
                'response' => false,
                'message' => 'No Election Started'
            ]);
        }else{
            return response()->json([
                'response' => true,
                'message' => 'Election Started'
            ]);
        }
    }
    public function voting_start(Request $request){

        $election = elections::select('election_title', 'tbl_year')
        ->where('department', $request->organization)
        ->where('status', 'started')
        ->first();

        $position = votingcomponents::select('position')->where('status', 3)
        ->get();

        

        $data = [];

        foreach ($position as $positions) {

            $data[$positions->position] = votingcandidate::select([
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'partylist',
                'position',
                'candidate_image'
            ])
            ->where('organization', $request->organization)
            ->where('election_title', $election->election_title)
            ->where('election_year', $election->tbl_year)
            ->where('position', $positions->position)
            ->get();

        }

        return response()->json([

            'data' => $data
            // 'vote' => $data["vote"]

        ]);

    }

    public function realtime_result(Request $request){

        $election = elections::select('election_title', 'tbl_year')
        ->where('department', $request->organization)
        ->where('status', 'started')
        ->first();

        if (!$election) {
            return response()->json([
                'response' => false,
                'message' => 'No election found'
            ]);
        }

        $position = votingcomponents::select('position')->where('status', 3)
        ->get();

        $count = voters::where('organization', $request->organization)->count();

        $data = [];
        $votes = [];

        foreach ($position as $positions) {

            $data[$positions->position] = votingcandidate::select([
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'partylist',
                'position',
                'candidate_image',
                'vote'
            ])
            ->where('organization', $request->organization)
            ->where('election_title', $election->election_title)
            ->where('election_year', $election->tbl_year)
            ->where('position', $positions->position)
            ->get();

        }

        return response()->json([

            'data' => $data,
            'voters' => $count

        ]);

    }

    public function dashboardChart(Request $request){

        $election = elections::where('department', $request->query('organization'))
                ->where('status', 'started')
                ->orderby('id', 'desc')
                ->first();

        if (!$election) {
           return response()->json([
                'response' => false,
                'message' => 'No Election Found'
           ]);
        }

        $position = votingcomponents::select('position')->where('status', 3)
        ->get();

        

        $data = [];

        foreach ($position as $positions) {

            $data[$positions->position] = votingcandidate::select([
                'first_name',
                'last_name',
                'vote'
            ])
            ->where('organization', $request->organization)
            ->where('election_title', $election->election_title)
            ->where('election_year', $election->tbl_year)
            ->where('position', $positions->position)
            ->get();

        }

        return response()->json([

            'data' => $data

        ]);

    }

    public function isVoted(Request $request){

        if ($request->election_year == 'nodata' && $request->election_title == 'nodata') {
            return response()->json([
                'response' => 2
            ]);
        }else{
            
            $exist = ballot::where('fingerprint', $request->id)
                ->where('election_year', $request->election_year)
                ->where('election_title', $request->election_title)
                ->exists();

            if (!$exist) {
                return response()->json([
                    'response' => 1
                ]);
            }else{
                return response()->json([
                    'response' => 2
                ]);
            }
        }

        
    }

}
