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

class SubAdminController extends Controller
{
    // --- OTP Verification ---
    public function verify_otp(Request $request)
    {
        $otp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;
        $exists = voters::where('id', $request->id)->where('otp', $otp)->exists();

        if ($exists) {
            Session::put('otp', 'valid');
            return redirect('user/dashboard');
        } else {
            return back()->with([
                'response' => 2,
                'message' => 'Incorrect OTP'
            ]);
        }
    }

    // --- Position Management ---
    public function subadmin_update_position(Request $request)
{
    $request->validate([
        'position' => 'required|string|max:255',
        'maxvote' => 'required|integer|min:1',
    ]);

    votingcomponents::where('id', $request->id)->update([
        'position' => $request->position,
        'maxvote' => $request->maxvote,
    ]);

    return back()->with([
        'response' => 1,
        'message' => 'Update Position Successfully',
    ]);
}
    public function action_delete_position(Request $request)
{
    // Attempt to delete the record where 'id' matches the request
    $deleted = votingcomponents::where('id', $request->id)->delete();

    if ($deleted) {
        return back()->with([
            'response' => 2,
            'message' => 'Position Removed Successfully'
        ]);
    } else {
        return back()->with([
            'response' => 0,
            'error' => 'Position not found or already deleted'
        ]);
    }
}

    

    // --- Candidate Management ---
    // --- Candidate Management ---
    public function subadmin_add_candidate(Request $request)
    {
        try {
            // Validate the input fields
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'position' => 'required|string|max:255',
                'partylist' => 'nullable|string|max:255',
                
            ]);
    
            $data = $request->all();
    
            // Check if election exists
            $election = elections::find($request->id);
            if (!$election) {
                return back()->with([
                    'response' => 0,
                    'message' => "Election not found.",
                ]);
            }
    
            // Check if a candidate with the same name and position exists for this election
            $exists = votingcandidate::where('first_name', $request->first_name)
                ->where('last_name', $request->last_name)
                ->where('position', $request->position)
                ->where('election_title', $election->election_title)
                ->where('election_year', $election->tbl_year)
                ->exists();
    
            if ($exists) {
                return back()->with([
                    'response' => 2,
                    'message' => "The candidate {$request->first_name} {$request->last_name} already exists for the position of {$request->position}.",
                ]);
            }
    
            // Process candidate image
            $img1 = $request->file('candidate_image');
            $img1_name = uniqid() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('../public/images'), $img1_name);
            $data['candidate_image'] = $img1_name;
    
            // Process certificate of candidacy (if provided)
            if ($request->hasFile('cert_of_candidacy')) {
                $img2 = $request->file('cert_of_candidacy');
                $img2_name = uniqid() . '.' . $img2->getClientOriginalExtension();
                $img2->move(public_path('../public/images'), $img2_name);
                $data['cert_of_candidacy'] = $img2_name;
            } else {
                $data['cert_of_candidacy'] = null;
            }
    
            $data['organization'] = session()->get('organization');
    
            // Save the new candidate
            $model = new votingcandidate;
            $model->fill($data);
            $model->save();
    
            return back()->with([
                'response' => 1,
                'message' => "{$data['first_name']} {$data['last_name']} added successfully for the position of {$data['position']}.",
            ]);
        } catch (Exception $e) {
            \Log::error('Error adding candidate: ' . $e->getMessage());
    
            return back()->with([
                'response' => 0,
                'message' => 'An error occurred while adding the candidate. Please try again later.',
            ]);
        }
    }


public function subadmin_update_candidate(Request $request)
{
    try {
        // Find the candidate by ID
        $candidate = votingcandidate::find($request->id);

        if (!$candidate) {
            return back()->with(['response' => 0, 'message' => 'Candidate not found.']);
        }

        // Prepare updated data
        $data = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'candidate_image'=> $request -> candidate_image,
            'cert_of_candidacy'=> $request -> cert_of_candidacy
        ];

        // Handle image and certificate updates
        if ($request->hasFile('candidate_image')) {
            $img1 = $request->file('candidate_image');
            $img1_name = uniqid() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('../public/images'), $img1_name);
            $data['candidate_image'] = $img1_name;  // Update candidate image
        }

        if ($request->hasFile('cert_of_candidacy')) {
            $img2 = $request->file('cert_of_candidacy');
            $img2_name = uniqid() . '.' . $img2->getClientOriginalExtension();
            $img2->move(public_path('../public/images'), $img2_name);
            $data['cert_of_candidacy'] = $img2_name;  // Update certificate of candidacy
        }

        // Update the candidate record in the database
        $candidate->update($data);

        return back()->with([
            'response' => 1,
            'message' => 'Candidate updated successfully.'
        ]);

    } catch (Exception $e) {
        return back()->with(['response' => 2, 'message' => $e->getMessage()]);
    }
}
    public function subadmin_delete_candidate(Request $request)
{
    // Attempt to delete the record where 'id' matches the request
    $deleted = votingcandidate::where('id', $request->id)->delete();

    if ($deleted) {
        // Record successfully deleted
        return back()->with([
            'response' => 2,
            'message' => 'Candidate Removed Successfully'
        ]);
    } 
}

// --- Candidate Viewing ---
public function subadmin_view_candidate(Request $request)
{
    $election = elections::where('id', $request->query('id'))->first();
    $data = votingcomponents::select('partylist')
            ->where('status', 2)
            ->where('organization', session()->get('organization'))
            ->get();

    $listcandidate = votingcandidate::select('id','first_name', 'last_name', 'middle_name', 'partylist', 'position', 'candidate_image')
            ->where('position', $request->query('position'))
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


    // --- Add Position ---
    public function subadmin_add_position(Request $request)
{
    try {
        // Validate the incoming request
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'maxvote' => 'required|integer|min:1',
        ]);

        $data = $validated;
        $data["status"] = 3;
        $data["organization"] = Session::get('organization');

        // Check if the position already exists
        $exist = votingcomponents::where('position', $data["position"])
            ->where('organization', $data["organization"])
            ->exists();

        if ($exist) {
            return back()->with([
                'error' => 'The position already exists',
                'response' => 2
            ]);
        }

        // Save the data to the database
        $result = votingcomponents::create($data);
        if (!$result) {
            return back()->with([
                'error' => 'Failed to add the position.',
                'response' => 2
            ]);
        }

        return back()->with([
            'message' => 'Position added successfully with max votes set to ' . $data["maxvote"],
            'response' => 1
        ]);
    } catch (Exception $e) {
        return back()->with([
            'error' => $e->getMessage(),
            'response' => 2
        ]);
    }
}


    // --- Add Partylist ---
    public function subadmin_add_partylist(Request $request)
    {
        try {
            $data = $request->all();
            unset($data["_token"]);
            $data["status"] = 2;
            $data["organization"] = session()->get('organization');
    
            $existingpartylist = votingcomponents::where('partylist', $data['partylist'])->first();
    
            if ($existingpartylist) {
                return back()->with([
                    'error' => 'The partylist already exists.',
                    'response' => 2
                ]);
            }
    
            $result = votingcomponents::create($data);
            if (!$result) {
                return back()->with([
                    'error' => 'Failed to add the position.',
                    'response' => 2
                ]);
            }
    
            return back()->with([
                'message' => 'Partylist added successfully.',
                'response' => 1
            ]);
    
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return back()->with([
                    'error' => 'The position already exists.',
                    'response' => 2
                ]);
            }
            return back()->with([
                'error' => $e->getMessage(),
                'response' => 2
            ]);
        } catch (Exception $e) {
            return back()->with([
                'error' => $e->getMessage(),
                'response' => 2
            ]);
        }
    }
    
    public function subadmin_update_partylist(Request $request)
    {
        $result = votingcomponents::where('id', $request->id)->update([
            'partylist' => $request->partylist,
        ]);
    
        if ($result) {
            return back()->with([
                'message' => 'Updated Partylist Successfully.',
                'response' => 1
            ]);
        } else {
            return back()->with([
                'error' => 'Failed to update Partylist.',
                'response' => 2
            ]);
        }
    }
    
    public function subadmin_delete_partylist(Request $request)
    {
        // Attempt to delete the record where 'id' matches the request
        $deleted = votingcomponents::where('id', $request->id)->delete();
    
        if ($deleted) {
            // Record successfully deleted
            return back()->with([
                'message' => 'Partylist Removed.',
                'response' => 2
            ]);
        } else {
            // Error deleting the record
            return back()->with([
                'error' => 'Failed to delete the partylist.',
                'response' => 2
            ]);
        }
    }
    

    // --- Voter Actions ---
    public function subadmin_add_voter(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:voters,email',
                'pin' => 'required|numeric|digits:8',
            ]);

            $validatedData['organization'] = session()->get('organization');
            $validatedData['status'] = 'pending';

            voters::create($validatedData);

            return back()->with([
                'response' => 1,
                'message' => 'New Voter Added successfully',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with([
                'response' => 2,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function subadmin_update_voter(Request $request)
    {
        voters::where('id', $request->id)->update([
            'email' => $request->email,
            'pin' => $request->pin
        ]);
        return back()->with([
            'response' => 1,
            'message' => 'Update Voter Successfully'
        ]);
    }

    public function action_delete_voters(Request $request)
    {
        if (voters::where('id', $request->id)->delete()) {
            return back()-> with([
                'response' => 2,
                'message' => 'Voter Removed'
            ]);
        }
    }

    // --- Election Actions ---
    public function subadmin_add_election(Request $request)
{
    try {
        $data = $request->all();
        $data["status"] = "pending";
        $data["department"] = session()->get('organization');
        unset($data['_token']);

        // Check if the election already exists for the same date or year in the department
        $exist = elections::where('tbl_date', $data["tbl_date"])
            ->where('department', $data["department"])
            ->exists();

        $exist_year = elections::where('tbl_year', $data["tbl_year"])
            ->where('department', $data["department"])
            ->exists();

        if ($exist || $exist_year) {
            return back()->with([
                'response' => 2,
                'message' => 'An election with the same date or year already exists in your department.'
            ]);
        }

        // Save the election to the database
        $model = new elections;
        $model->fill($data);
        $model->save();

        return back()->with([
            'response' => 1,
            'message' => 'Election added successfully.'
        ]);
    } catch (\Exception $e) {
        return back()->with([
            'response' => 2,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

    public function subadmin_update_election(Request $request)
    {
        elections::where('id', $request->id)->update([
            'election_title' => $request->election_title,
            'tbl_year' => $request->tbl_year,
            'tbl_date' => $request->tbl_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'required_partylist' => $request->required_partylist,
           
        ]);

        return back()->with([
            'response' => 1,
            'message' => 'Update Election Successfully'
        ]);
        
    }

    public function subadmin_action_delete(Request $request){
        
        $id =  $request->query('id');

        try {
            
            elections::where('id', $id)->delete();

            return back()->with([
                'response' => 1,
                'message' => 'Election Deleted Successfully'
            ]);

        } catch (Exception $e) {

            return response()->json([

                'error message' => $e->getMessage()

            ]);
            
        }

    }

    public function vote_action(Request $request)
    {
      
        try {
            $election = elections::where('id', $request->id)->first();

            if (!$election) {
                return back()->with([
                    'response' => 2,
                    'message' => 'Election not found.'
                ]);
            }

            $currentStatus = $election->status;

            if ($request->status === 'started' && $currentStatus === 'pending') {
                $hasCandidate = votingcandidate::where('election_title', $election->election_title)
                    ->where('election_year', $election->tbl_year)
                    ->exists();

                if (!$hasCandidate) {
                    return back()->with([
                        'response' => 2,
                        'message' => 'Cannot start the voting session if there are no candidates.'
                    ]);
                }

                $otherElectionRunning = elections::where('department', $election->department)
                    ->where('status', 'started')
                    ->exists();

                if ($otherElectionRunning) {
                    return back()->with([
                        'response' => 2,
                        'message' => 'Cannot start this election because another election is in progress.'
                    ]);
                }

                $election->update(['status' => 'started']);
                $phones = voters::where('organization', Session::get('organization'))
                    ->pluck('phone_number')
                    ->toArray();

                $subadmin_message = $request->message;
                $this->sendSMStoAll($phones, $subadmin_message);

                return back()->with([
                    'response' => 1,
                    'message' => 'Election started successfully.'
                ]);
            } elseif ($request->status === 'done' && $currentStatus === 'started') {
                $election->update(['status' => 'done']);
                $phones = voters::where('organization', Session::get('organization'))
                    ->pluck('phone_number')
                    ->toArray();

                $subadmin_message = $request->message;
                $this->sendSMStoAll($phones, $subadmin_message);

                return back()->with([
                    'response' => 1,
                    'message' => 'Election finished successfully.'
                ]);
            }
        } catch (\Exception $e) {
            return back()->with([
                'response' => 2,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function sendSMStoAll($phone, $message)
    {
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

    // --- View Results ---
    public function view_result(Request $request)
    {
        $positions = votingcomponents::select('position')
            ->where('organization', Session::get('organization'))
            ->where('status', 3)
            ->get();

        $candidates = votingcandidate::select('first_name', 'middle_name', 'last_name', 'position', 'vote', 'organization', 'election_title', 'election_year')
            ->where('election_title', $request->election_title)
            ->where('election_year', $request->election_year)
            ->where('organization', Session::get('organization'))
            ->get();

        $sortedCandidates = [];
        foreach ($positions as $position) {
            $filteredCandidates = $candidates->filter(function ($candidate) use ($position) {
                return $candidate->position == $position->position;
            });

            $sortedByVotes = $filteredCandidates->sortByDesc('vote');
            $sortedCandidates[$position->position] = $sortedByVotes->values()->all();
        }

        return view('subadmin.view-result', [
            'label' => 'View Result',
            'data' => $sortedCandidates,
            'election_title' => $request->election_title,
            'election_year' => $request->election_year,
            'status' => $request->status
        ]);
    }

    // --- Print Results ---
    public function print(Request $request)
    {
        $electionTitle = $request->query('election_title');
        $electionYear = $request->query('election_year');
        $organization = Session::get('organization');

        $votersCount = voters::where('organization', $organization)->count();

        if ($votersCount === 0) {
            return response()->json(['message' => 'No data found']);
        }

        $uniqueBallots = Ballot::where('election_title', $electionTitle)
            ->where('election_year', $electionYear)
            ->where('organization', $organization)
            ->get()
            ->unique('fingerprint');

        $uniqueBallotsCount = count($uniqueBallots);
        $sum = $uniqueBallotsCount / $votersCount;
        $percentage = $sum * 100;

        $data = json_decode($request->query('data'), true);
        $candidatesByPosition = [];
        foreach ($data as $position => $candidates) {
            foreach ($candidates as $candidate) {
                $candidatesByPosition[$position][] = $candidate;
            }
        }

        return view('subadmin.print-result', compact('electionTitle', 'electionYear', 'candidatesByPosition','uniqueBallotsCount', 'votersCount', 'percentage'));
    }
}
