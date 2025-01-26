<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\elections;

use App\Models\voters;

use App\Models\ballot;

use App\Models\User;

use App\Models\votingcandidate;

use App\Models\votingcomponents;

use Illuminate\Support\Facades\Session;

class subadminAPIcontroller extends Controller
{
    public function update_election() {
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
    
        try {
            // Example condition, if any
            // if (someCondition) {
            //     // Do something
            // }
    
            // Update elections that are "pending" and not started yet
            $pendingElections = elections::whereDate('tbl_date', '>=', $date)
                ->where('status', 'pending')
                ->where('start_time', '>=', $time)
                ->update(['status' => 'started']);
    
            // Update elections that are "started" and still ongoing
            $completedElections = elections::whereDate('tbl_date', '>=', $date)
                ->where('status', 'started')
                ->where('end_time', '>=', $time)
                ->update(['status' => 'done']);
    
            return response()->json([
                'message' => 'Election statuses updated successfully.',
                'date' => $date,
                'time' => $time,
                'updated_pending_elections' => $pendingElections,
                'updated_completed_elections' => $completedElections
            ]);
    
        } catch (Exception $e) {
            // Log error for debugging purposes
            Log::error('Election update failed: ' . $e->getMessage());
    
            // Return a meaningful error response
            return response()->json([
                'error' => 'An error occurred while updating the elections.'
            ], 500);
        }
    }
    

    public function realtimedata(Request $request){
        try {
            $data = [];

            if ($request->gender == 'all') {
                $data = [
                    'male' => voters::where('gender', 'male')->count(),
                    'female' => voters::where('gender', 'female')->count(),
                ]; // Added semicolon
            } else {
                $data[$request->gender] = voters::where('gender', $request->gender)->count();
            }

            return response()->json([
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500); // Added error response
        }
    }

    public function realtime_tbl(Request $request){
        // Find the latest ballot for the organization
        $ballot = ballot::where('organization', $request->organization)
            ->orderBy('id', 'desc')
            ->first();

        if (!$ballot) {
            return response()->json([
                'response' => 2,
                'message' => 'No Data Found'
            ]);
        }

        // Get unique user fingerprints based on the ballot details
        $users = ballot::select('fingerprint')
            ->where('election_year', $ballot->election_year)
            ->where('election_title', $ballot->election_title)
            ->where('organization', $ballot->organization)
            ->distinct()
            ->get();

        // Prepare default response if no users
        if ($users->isEmpty()) {
            return response()->json([
                'response' => 2,
                'message' => 'No Data Found'
            ]);
        }

        // Initialize the data array
        $data = [];

        switch ($request->data) {
            case 'voted':
                // Fetch voters who have voted
                $fingerprints = $users->pluck('fingerprint')->toArray();
                $data = voters::select('first_name', 'last_name', 'middle_name', 'age', 'gender', 'organization')
                    ->where('organization', $request->organization)
                    ->whereIn('fingerprint', $fingerprints)  // Only voters who have voted
                    ->get();

                break;

            case 'not voted':
                // Fetch voters who have not voted
                $fingerprints = $users->pluck('fingerprint')->toArray();
                $data = voters::select('first_name', 'last_name', 'middle_name', 'age', 'gender', 'organization')
                    ->where('organization', $request->organization)
                    ->whereNotIn('fingerprint', $fingerprints)  // Only voters who haven't voted
                    ->get();

                break;

            default:
                // Fetch all voters in the organization
                $data = voters::select('first_name', 'last_name', 'middle_name', 'age', 'gender', 'organization')
                    ->where('organization', $request->organization)
                    ->get();

                break;
        }

        // If no data found, return an error message
        if ($data->isEmpty()) {
            return response()->json([
                'response' => 2,
                'message' => 'No Data Found'
            ]);
        }

        // Return the successful response with data
        return response()->json([
            'data' => $data
        ]);
    }

    public function realtime_chart(Request $request){

        $ballot = ballot::where('organization', $request->organization)
    ->orderby('id', 'desc')->first();

    if (!$ballot) {
            
        return response()->json([

            'response' => 2

        ]);

    }

    $user_voted = ballot::select('fingerprint')
        ->where('election_year', $ballot->election_year)
        ->where('election_title', $ballot->election_title)
        ->where('organization', $request->organization)
        ->get()
        ->unique('fingerprint');

    // Extracting fingerprints from the user_voted collection
    $user_voted_fingerprints = $user_voted->pluck('fingerprint')->toArray();

    $count_not_voted = 0;
    $count_voted = 0;

    $voters = voters::select('fingerprint')
        ->where('organization', $request->organization)
        ->get()
        ->unique('fingerprint');

    foreach ($voters as $voter) {
        // Check if the voter's fingerprint is in the user_voted_fingerprints array
        if (!in_array($voter->fingerprint, $user_voted_fingerprints)) {
            $count_not_voted++;
        } else {
            $count_voted++;
        }
    }

    $male = voters::where('organization', $request->organization)
        ->where('gender', 'male')
        ->count();
    $female = voters::where('organization', $request->organization)
        ->where('gender', 'female')
        ->count();

    $age_b_18 = voters::where('organization', $request->organization)
                ->where('status', 'registered')
                ->where('age', '<', 18)
                ->count();
    $age_g_18 = voters::where('organization', $request->organization)
                ->where('status', 'registered')
                ->where('age', '>=', 18)
                ->where('age', '<=', 21)
                ->count();
    $age_g_21 = voters::where('organization', $request->organization)
                ->where('status', 'registered')
                ->where('age', '>', 21)
                ->count();
                

        return response()->json([

            'voters_count' => $voters->count(),
            'count_voted' => $count_voted,
            'count_not_voted' => $count_not_voted,
            'male' => number_format(($male / $voters->count()) * 100, 2),
            'female' => number_format(($female / $voters->count()) * 100, 2),
            'age' => [

                'below_18' => number_format(($age_b_18 / $voters->count()) * 100, 2),
                'range_18_21' => number_format(($age_g_18 / $voters->count()) * 100, 2),
                'greater_21' => number_format(($age_g_21 / $voters->count()) * 100, 2)

            ]


        ]);

    }

    public function voters(Request $request){

        $value = [];
        $election = votingcandidate::where('organization', $request->query('organization'))
        ->orderby('id', 'desc')
        ->first();

        switch ($request->query('value')) {
            case 'voted':
                $voted = ballot::select('fingerprint')
                        ->where('election_title', $election->election_title)
                        ->where('organization', $request->query('organization'))
                        ->get()
                        ->unique('fingerprint');
                $value = [ 'value' => count($voted) ];
                break;

            case 'notvoted':
                $ballot = ballot::select('fingerprint')
                    ->where('election_title', $election->election_title)
                    ->where('organization', $request->query('organization'))
                    ->get()
                    ->unique('fingerprint')
                    ->pluck('fingerprint')
                    ->toArray(); // Convert to array

                $notvoted = voters::select('id')
                    ->where('organization', $request->query('organization'))
                    ->whereNotIn('id', $ballot) // Now $ballot is an array
                    ->count();


                $value = [ 'value' => $notvoted ];
                break;
            
            default:
                $total = voters::select('id')
                        ->where('organization', $request->query('organization'))
                        ->count();
                $value = ['value' => $total];
                break;
        }
            

        return response()->json([
            'data' => $value
        ]);
    }

    public function voterbygender(Request $request){

        $position = $request->query('position');
        
        $election = elections::where('department', $request->query('organization'))
                ->where('status', 'started')
                ->orderby('id', 'desc')
                ->first();

        if (!$election) {
            return response()->json([
                'response' => 2,
                'message' => 'No Election Started'
            ]);
        }

        $candidates = votingcandidate::select('id')
            ->where('position', $position)
            ->where('organization', $request->query('organization'))
            ->get();

        $ballot = ballot::select('fingerprint')
            ->whereIn('voted_candidates', $candidates)
            ->where('election_title', $election->election_title)
            ->where('organization', $request->query('organization'))
            ->get();

        
        $male = voters::whereIn('id', $ballot)->where('gender', 'Male')->count();
        $female = voters::whereIn('id', $ballot)->where('gender', 'Female')->count();

        return response()->json([

            'data' => [
                'male' => $male,
                'female' => $female
            ]

        ]);
    }

    public function voterbycourse(Request $request){

        $position = $request->query('position');
        
        $election = elections::where('department', $request->query('organization'))
                ->where('status', 'started')
                ->orderby('id', 'desc')
                ->first();

        if (!$election) {
            return response()->json([
                'response' => 2,
                'message' => 'No Election Started'
            ]);
        }

        $candidates = votingcandidate::select('id')
            ->where('position', $position)
            ->where('organization', $request->query('organization'))
            ->get();

        $ballot = ballot::select('fingerprint')
            ->whereIn('voted_candidates', $candidates)
            ->where('election_title', $election->election_title)
            ->where('organization', $request->query('organization'))
            ->get();
        
        $course = voters::select('course')
            ->where('organization', $request->query('organization'))
            ->get()
            ->unique('course')
            ->pluck('course')
            ->toArray();

        $data = voters::select('course')
            ->whereIn('id', $ballot)
            ->whereIn('course', $course)
            ->count();

        return response()->json([
            'count' => $data,
            'course' => $course
        ]);
    }

    public function candidate_vote_info(Request $request){

        $id = $request->query('id');

        $getId = ballot::select('fingerprint')
                    ->where('voted_candidates', $id)
                    ->get()
                    ->pluck('fingerprint')
                    ->toArray();

        $getMaleVoters = voters::whereIn('id', $getId)
                    ->where('gender', 'male')
                    ->count();

        $getFemaleVoters = voters::whereIn('id', $getId)
                    ->where('gender', 'female')
                    ->count();

        $math = voters::whereIn('id', $getId)
            ->where('course', 'math')
            ->count();
        $filipino = voters::whereIn('id', $getId)
            ->where('course', 'filipino')
            ->count();
        $english = voters::whereIn('id', $getId)
            ->where('course', 'english')
            ->count();
        $socstud = voters::whereIn('id', $getId)
            ->where('course', 'socstud')
            ->count();
        $beed = voters::whereIn('id', $getId)
            ->where('course', 'beed')
            ->count();
        $bped = voters::whereIn('id', $getId)
            ->where('course', 'bped')
            ->count();
        $bsit = voters::whereIn('id', $getId)
            ->where('course', 'bsit')
            ->count();
        $bshm = voters::whereIn('id', $getId)
            ->where('course', 'bshm')
            ->count();
        
        $first_year = voters::whereIn('id', $getId)
            ->where('year_lvl', 1)
            ->count();
        $second_year = voters::whereIn('id', $getId)
            ->where('year_lvl', 2)
            ->count();
        $third_year = voters::whereIn('id', $getId)
            ->where('year_lvl', 3)
            ->count();
        $fourth_year = voters::whereIn('id', $getId)
            ->where('year_lvl', 4)
            ->count();
        
        return response()->json([
            'gender' => [
                'male' => $getMaleVoters,
                'female' => $getFemaleVoters
            ],
            'course' => [
                'math' => $math,
                'filipino' => $filipino,
                'english' => $english,
                'socstud' => $socstud,
                'beed' => $beed,
                'bped' => $bped,
                'bsit' => $bsit,
                'bshm' => $bshm,
            ],
            'year_level' => [
                '1st_year' => $first_year,
                '2nd_year' => $second_year,
                '3rd_year' => $third_year,
                '4th_year' => $fourth_year,
            ]
        ]);
        
                
    }

}
