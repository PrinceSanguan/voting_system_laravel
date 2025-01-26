<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\votingcomponents;

use App\Models\votingcandidate;

use App\Models\voters;

use App\Models\elections;

use App\Models\ballot;

use Session;
use Illuminate\Support\Facades\Http;


class subadminController extends Controller
{

    public function verify_otp(Request $request){

        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;

        $exists = voters::where('id', $request->id)->where('otp', $otp)->exists();

        if ($exists) {
            Session::put('otp', 'valid');
            return redirect('user/dashboard');
        }else{
            return back()->with([
                'response' => 2,
                'message' => 'Incorrect OTP'
            ]);
        }

    }

    public function subadmin_update_position(Request $request){
        votingcomponents::where('id', $request->id)->update([
            'position' => $request->position
        ]);
        return back();
    }

    public function subadmin_add_candidate(Request $request){

        // echo $request->id;

        try {

            $data = $request->all();

            $election = elections::where('id', $request->id)->first();

            if (!$election) {
                return back()->with([
                    'response' => 0,
                    'message' => "Election not found."
                ]);
            }

            $exist = votingcandidate::where('first_name', $request->first_name)
                    ->where('last_name', $request->last_name)
                    ->where('election_title', $election->election_title)
                    ->where('election_year', $election->tbl_year)
                    ->exists();

            if ($exist) {
                return back()->with([
                    'response' => 2,
                    'message' => "The candidate {$request->first_name} {$request->last_name} already exists."
                ]);
            }

            // echo $exist;



            if ($request->partylist != "no") {

                $exists = votingcandidate::where('partylist', $request->partylist)
                ->where('position', $request->position)
                ->exists();

                if ($exists) {

                    return back()->with([

                        'response' => 2,
                        'message' => "The {$data['position']} position is already exists from {$data["partylist"]} partylist."

                    ]);

                }

            }else{

                unset($data["partylist"]);

            }

            
            if ($request->hasFile('candidate_image') && $request->hasFile('cert_of_candidacy')) {
            
                $img1 = $request->file('candidate_image');
                $img2 = $request->file('cert_of_candidacy');

                $img1_name = uniqid() . '.' . $img1->getClientOriginalExtension();
                $img2_name = uniqid() . '.' . $img2->getClientOriginalExtension();

                $img1->move(public_path('../public/images'), $img1_name);
                $img2->move(public_path('../public/images'), $img2_name);


                $data["candidate_image"] =$img1_name;
                $data["cert_of_candidacy"] = $img2_name;
                $data["organization"] = session()->get('organization');

                $model = new votingcandidate;

                $model->fill($data);

                $model->save();


                return back()->with([

                    'response' => 1,
                    'message' => $data["first_name"]." ". $data["last_name"]. " added successfully for the position of ". $data["position"]

                ]);

            }


        } catch (Exception $e) {
            
        }
    }

    public function subadmin_view_candidate(Request $request){

        $election = elections::where('id', $request->query('id'))->first();

        $data = votingcomponents::select('partylist')
                ->where('status', 2)
                ->where('organization', session()->get('organization'))
                ->get();

        $listcandidate = votingcandidate::select('id','first_name', 'last_name', 'middle_name', 'partylist', 'position', 'candidate_image')
                ->where('position',$request->query('position'))
                ->where('organization', session()->get('organization'))
                ->where('election_title', $request->query('election_title'))
                ->where('election_year', $election->tbl_year)
                ->get();

            return view('subadmin.candidates-list', [

                    'label' => 'Candidate List',
                    'data' => $request->query('position'),
                    'partylist' => $data,
                    'listcandidate' => $listcandidate,
                    'year' => $election->tbl_year

            ]);

    }
    public function subadmin_add_position(Request $request){
        try {

            $data = $request->all();
        
            unset($data["_token"]);
            $data["status"] = 3;
            $data["organization"] = Session::get('organization');

            $exist = votingcomponents::where('position', $data["position"])
            ->where('organization', Session::get('organization'))
            ->exists();

            if ($exist) {
                // return back()->with([
                //     'error'=> 'The position already exists.',
                //     'response' => 2
                // ]);
                echo $exist;
            }

            $result = votingcomponents::create($data);

            if (!$result) {

                return back()->with([
                    'error'=> 'Failed to add the position.',
                    'response' => 2
                ]);

            }

            return back()->with([
                'success'=> 'Position added successfully.',
                'response' => 1
            ]);

        } catch (Exception $e) {

            return back()->with([
                'error'=> $e->getMessage(),
                'response' => 2
            ]);

        }

        

        if ($exist) {

            echo "1";
        }else{
            echo "2";
        }

    }


    public function subadmin_add_partylist(Request $request){
        try {

            $data = $request->all();
            unset($data["_token"]);
            $data["status"] = 2;
            $data["organization"] = session()->get('organization');

            $existingpartylist = votingcomponents::where('partylist', $data['partylist'])->first();
            
            if ($existingpartylist) {
                return back()->with([
                    'error'=> 'The position already exists.',
                    'response' => 2
                ]);
            }

            $result = votingcomponents::create($data);

            if (!$result) {

                return back()->with([
                    'error'=> 'Failed to add the position.',
                    'response' => 2
                ]);

            }

            return back()->with([
                'success'=> 'Position added successfully.',
                'response' => 1
            ]);

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {

                return back()->with([
                    'error'=> 'The position already exists.',
                    'response' => 2
                ]);

            }

            return back()->with([
                'error'=> $e->getMessage(),
                'response' => 2
            ]);

        } catch (Exception $e) {

            return back()->with([
                'error'=> $e->getMessage(),
                'response' => 2
            ]);

        }
    }

    public function subadmin_action_delete(Request $request){
        
        $id =  $request->query('id');

        try {
            
            votingcomponents::where('id', $id)->delete();

            return back();


        } catch (Exception $e) {

            return response()->json([

                'error message' => $e->getMessage()

            ]);
            
        }

    }

    public function action_delete_voters(Request $request){
        
        if (voters::where('id', $request->id)->delete()) {
            return back();
        }

    }

    public function subadmin_action_delete_candidates(Request $request){

        // dd($request->all());

        try {
            
            elections::where('id',$request->id)->delete();
            return back();


        } catch (Exception $e) {

             return response()->json([

                'error message' => $e->getMessage()

            ]);
            
        }

    }

    public function subadmin_add_voter(Request $request){

        try {

            $data = $request->all();
            unset($data["_token"]);
            $data["organization"] = session()->get('organization');
            $data["status"] = "pending";

            $exist = voters::where('email', $data["email"])
            ->where('organization', session()->get('organization'))
            ->exists();

            if ($exist) {
                
                return back()->with([

                    'response' => 2,
                    'message' => 'This user is already exist'

                ]);

            }

            voters::create($data);
            return back()->with([

                'response' => 1,
                'message' => 'New Voter Registered successfully'

            ]);

            
        } catch (Exception $e) {


            return back()->with([

                'response' => 2,
                'message' => "error message: ". $e->getMessage()

            ]); 
            
        }

    }

    public function subadmin_add_election(Request $request){

        try {
            
            $data = $request->all();
            $data["status"] = "pending";
            $data["department"] = session()->get('organization');
            unset($data['_token']);

            $exist = elections::where('tbl_date', $data["tbl_date"])
            ->where('department', Session::get('organization'))
            ->exists();
            
            $exist_year = elections::where('tbl_year', $data["tbl_year"])
            ->where('department', Session::get('organization'))
            ->exists();

            if ($exist) {

                return back()->with([

                    'response' => 2,
                    'message' => 'The Date Is Already Taken, Please Choose Another Date'

                ]);

            }

            if ($exist_year) {
                return back()->with([

                    'response' => 2,
                    'message' => 'The Year is already exist, Please Choose Another year'

                ]);
            }

            $model = new elections;

            $model->fill($data);

            $model->save();

            return back();


        } catch (Exception $e) {

            return response()->json([

                'messageError' => $e->getMessage()

            ]);
            
        }

        

    }


    public function vote_action(Request $request){

        try {

            $status = elections::select('department','status','election_title', 'tbl_year')
            ->where('id', $request->id)
            ->first();

            if ($status->status == 'pending') {

                $hasCandidate = votingcandidate::where('election_title', $status->election_title)
                ->where('election_year', $status->tbl_year)
                ->exists();

                if (!$hasCandidate) {

                    return back()->with([

                        'response' => 2,
                        'message' => 'Cannot start the voting session if there is no participants'

                    ]);
                
                }
                
                $exist = elections::where('department', $status->department)
                ->where('status', 'started')
                ->exists();

                if ($exist) {
                    
                    return back()->with([

                        'response' => 2,
                        'message' => 'The Election Cannot Start Because There is Other Election started or been paused'

                    ]);

                }

            }
            
            $message = '';
        
            if ($request->status == 'pending') {
                elections::where('id', $request->id)
                    ->update([

                        'status' => 'started'

                    ]);
                    $message = 'started';
                return back();
            }else{
                elections::where('id', $request->id)
                    ->update([
                        'status' => 'done'
                    ]);
                    $message = 'Finished';

                    $phones = voters::where('organization', Session::get('organization'))
                        ->get()
                        ->pluck('phone_number')
                        ->toArray();
                    $subadmin_message = $request->message;

                    return $this->sendSMStoAll($phones, $subadmin_message);
            }

           


        } catch (Exception $e) {
            
        }

    }

    public function sendSMStoAll($phone, $message){

        $apiKey = env('TEXTBEE_API_KEY');
        $deviceId = env('TEXTBEE_DEVICE_ID');
        $random = rand(1000, 9999);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->post("https://api.textbee.dev/api/v1/gateway/devices/{$deviceId}/sendSMS", [
            'recipients' => $phone,
            'message' => $message,
        ]);

        if ($response->successful()) {

            return back()->with([
                'response' => 1,
                'message' => 'Election Finish'
            ]);

        } else {
            return response()->json(['error' => 'Failed to send SMS.']);
        }

    }

   public function view_result(Request $request){
        // Retrieve positions for the current organization
        $positions = votingcomponents::select('position')
            ->where('organization', Session::get('organization'))
            ->where('status', 3)
            ->get();

        // Retrieve candidates based on the election title, year, and organization
        $candidates = votingcandidate::select('first_name', 'middle_name', 'last_name', 'position', 'vote', 'organization', 'election_title', 'election_year')
            ->where('election_title', $request->election_title)
            ->where('election_year', $request->election_year)
            ->where('organization', Session::get('organization'))
            ->get();

        // Initialize an array to hold sorted candidates by position
        $sortedCandidates = [];

        // Iterate over each position
        foreach ($positions as $position) {
            // Filter candidates matching the current position
            $filteredCandidates = $candidates->filter(function ($candidate) use ($position) {
                return $candidate->position == $position->position;
            });

            // Sort candidates by 'vote' count, descending
            $sortedByVotes = $filteredCandidates->sortByDesc('vote');

            // Add sorted candidates to the result array
            $sortedCandidates[$position->position] = $sortedByVotes->values()->all();
        }

        // Return the sorted candidates as a JSON response
        // return response()->json([
        //     'data' => $sortedCandidates
        // ]);

        return view('subadmin.view-result', [

            'label' => 'View Result',
            'data' => $sortedCandidates,
            'election_title' => $request->election_title,
            'election_year' => $request->election_year,
            'status' => $request->status

        ]);
    }


    public function print(Request $request){

        // Get the election title and year from the request
        $electionTitle = $request->query('election_title');
        $electionYear = $request->query('election_year');

        // Get the organization from the session
        $organization = Session::get('organization');

        // Count the number of voters associated with the organization
        $votersCount = voters::where('organization', $organization)->count();

        if ($votersCount === 0) {
            return response()->json([
                'message' => 'No data found'
            ]);
        }

        // Fetch unique ballots based on fingerprint for the given election title, year, and organization
        $uniqueBallots = Ballot::where('election_title', $electionTitle)
            ->where('election_year', $electionYear)
            ->where('organization', $organization)
            ->get()
            ->unique('fingerprint');

        // Count of unique ballots
        $uniqueBallotsCount = count($uniqueBallots);

        $sum = $uniqueBallotsCount / $votersCount;

        $percentage = $sum * 100;

        $data = json_decode($request->query('data'), true);

        // Organize candidates by position
        $candidatesByPosition = [];
        foreach ($data as $position => $candidates) {
            foreach ($candidates as $candidate) {
                $candidatesByPosition[$position][] = $candidate;
            }
        }

        return view('subadmin.print-result', compact('electionTitle', 'electionYear', 'candidatesByPosition','uniqueBallotsCount', 'votersCount', 'percentage'));
    }




}
