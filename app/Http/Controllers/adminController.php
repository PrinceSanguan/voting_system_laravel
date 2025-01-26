<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\organizations;

use App\Models\votingcomponents;

use App\Models\votingcandidate;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Session;

use DB;

use Illuminate\Support\Facades\Crypt;

class adminController extends Controller
{
    public function admin_organization_account(Request $request){

        try {


            $exist = User::where('email', $request->email)
            ->where('Organization', $request->organization)
            ->where('Designation', 'Subadmin')
            ->exists();

            if (!$exist) {
                
                User::create([
                    'email' => $request->email,
                    'pin' => Crypt::encryptString($request->pin),
                    'name' => $request->name,
                    'role' => $request->role,
                    'age' => $request->age,
                    'gender' => $request->gender,
                    'Designation' => 'Subadmin',
                    'Status' => 1,
                    'Organization' => $request->organization
                ]);

                organizations::where('Organization', $request->organization)
                ->update([
                    'Status' => 2
                ]);

                return back()->with([

                    'response' => 1,
                    'message' => 'Account Created'

                ]);

            }else{


                return back()->with([

                    'response' => 2,
                    'message' => 'The email is already taken'

                ]);


            }
            
            


        } catch (Exception $e) {

            return back()->with([

                'response' => 2,
                'message' => 'error message: '. $e->getMessage()

            ]);
            
        }

    }

    public function admin_add_organization(Request $request){

        try {

            $organization = $request->input('organization');
            
            $exist = organizations::where('organization', $organization)->exists();

            if($exist){

                return back()->with([

                    'response' => 2,
                    'message' => 'The organization '. $organization. ' is already exist'

                ]);

            }

            organizations::create([
                'organization' => $organization,
                'program_course' => $request->program_course,
                'Status' => 1
            ]);

            return back()->with([

                'response' => 1,
                'message' => 'The organization '. $organization. ' Added successfully'

            ]);


        } catch (Exception $e) {

            return back()->with([

                    'response' => 2,
                    'message' => 'error message: ' . $organization

                ]);
            
        }

    }

    public function view_result(Request $request){

        // Retrieve positions for the current organization
        $positions = votingcomponents::select('position')
            ->where('organization', $request->organization)
            ->where('status', 3)
            ->get();

        // Retrieve candidates based on the election title, year, and organization
        $candidates = votingcandidate::select('first_name', 'middle_name', 'last_name', 'position', 'vote', 'organization', 'election_title', 'election_year')
            ->where('election_title', $request->election_title)
            ->where('election_year', $request->election_year)
            ->where('organization', $request->organization)
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

        return view('admin.result',[

            'label' => 'View Result',
            'data' => $sortedCandidates,
            'election_title' => $request->election_title,
            'election_year' => $request->election_year,
            'status' => $request->status

        ]);

    }

    public function update_account(Request $request){

        $data = $request->except('_token');

        // Update user account based on the fingerprint stored in session
        $result = User::where('id', Session::get('id'))->update($data);

        if ($result) {
            return back()->with('success', 'Account updated successfully!');
        } else {
            return back()->with('error', 'No changes were made.');
        }
    }

    public function action_delete(Request $request){

        // dd($request->all());
        $table = $request->table;

        DB::table($table)->where('id', $request->id)->delete();
        return back()->with([

            'response' => 1,
            'message' => 'User Account Removed'

        ]);

    }

}
