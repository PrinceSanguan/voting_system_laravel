<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\votingcomponents;

use App\Models\votingcandidate;

use App\Models\voters;

use App\Models\ballot;

use App\Models\organizations;

use App\Models\User;

use App\Models\elections;

use Session;

use DB;

class pageController extends Controller
{

    // otppp
    public function otp(){

        if (!Session::has('id')) {
            return back();
        }

        return view('otp');

    }

    // authentication

    public function login(Request $request){

        Session::put('ip', $request->schemeAndHttpHost());

        if(Session::has('user_fingerprint') && Session::get('Designation') == 'administrator'){

            return to_route('admin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == 'Subadmin'){

            return to_route('subadmin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == '' || Session::get('Designation') != null ){

            return redirect('user/dashboard');

        }

        return view('login');

    }
    public function login_page(Request $request){

        Session::put('ip', $request->schemeAndHttpHost());
        $data = organizations::all();
        return view ('auth',[
            'data' => $data
        ]);


    }

    public function register(){

        if(Session::has('user_fingerprint') && Session::get('Designation') == 'administrator'){

            return to_route('subadmin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == 'Subadmin'){

            return to_route('admin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == '' || Session::get('Designation') != null ){

            return redirect('user/dashboard');

        }

        return view('register');

    }

    public function reg_administrator(){

        if(Session::has('user_fingerprint') && Session::get('Designation') == 'administrator'){

            return to_route('admin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == 'Subadmin'){

            return to_route('subadmin.index');

        }elseif(Session::has('user_fingerprint') && Session::get('Designation') == '' || Session::get('Designation') != null ){

            return redirect('user/dashboard');

        }

        return view('reg');

    }

    // sub admin start

    public function subadmin_voters_turnout(Request $request){

        $election = elections::where('department', Session::get('organization'))
                    ->where('status', 'started')
                    ->orderby('id', 'desc')
                    ->first();

        if (!$election) {
            return view('subadmin.voters-turnout')->with([
                'label' => 'Voters Turnout',
                'response' => false,
                'message' => 'No Election Found'
            ]);
        }
        
       

        $voted = ballot::select('fingerprint')
                    ->where('election_title', $election->election_title)
                    ->where('organization', Session::get('organization'))
                    ->get()
                    ->unique('fingerprint')
                    ->pluck('fingerprint')
                    ->toArray();

        $ballot = ballot::select('fingerprint')
                    ->where('election_title', $election->election_title)
                    ->where('organization', Session::get('organization'))
                    ->get()
                    ->unique('fingerprint')
                    ->pluck('fingerprint')
                    ->toArray();

        $notvoted = voters::select('id')
                    ->where('organization', Session::get('organization'))
                    ->whereNotIn('id', $ballot) // Now $ballot is an array
                    ->count();

        $malevoted = voters::whereIn('id', $voted)
                    ->where('organization', Session::get('organization'))
                    ->where('gender', 'male')
                    ->count();
        $femalevoted = voters::whereIn('id', $voted)
                    ->where('organization', Session::get('organization'))
                    ->where('gender', 'female')
                    ->count();

        $malenotvoted = voters::select('id')->whereNotIn('id', $voted)
                    ->where('organization', Session::get('organization'))
                    ->where('gender', 'male')
                    ->count();

        $femalenotvoted = voters::select('id')->whereNotIn('id', $voted)
                    ->where('organization', Session::get('organization'))
                    ->where('gender', 'female')
                    ->count();
        $position = votingcomponents::select('position')
                    ->where('organization', Session::get('organization'))
                    ->where('status', 3)
                    ->get();

        $getVoterId = ballot::where('election_title', $election->election_title)
                    ->where('organization', Session::get('organization'))
                    ->get()
                    ->unique('fingerprint')
                    ->pluck('fingerprint')
                    ->toArray();

        $candidate = votingcandidate::where('election_title', $election->election_title)
                    ->where('organization', Session::get('organization'))
                    ->get();

        return view('subadmin.voters-turnout',[
            'response' => true,
            'label' => 'Voters Turnout',
            'voter' => [
                'voted' => count($voted),
                'notvoted' => $notvoted,
                'malevoted' => $malevoted,
                'femalevoted' => $femalevoted,
                'malenotvoted' => $malenotvoted,
                'femalenotvoted' => $femalenotvoted
            ],
            'candidate' => $candidate,
            'position' => $position
        ]);

    }

    public function subadmin_index_page() {
        // echo Session::get('Designation');



        $position = votingcomponents::where('organization', Session::get('organization'))
                ->where('status', 3)->count();
        $partylist = votingcomponents::where('organization', Session::get('organization'))
                ->where('status', 2)->count();

        $election = elections::where('department', Session::get('organization'))
                ->orderby('id', 'desc')
                ->first();

        $candidate = null;

        if (!$election) {
            $candidate = 0;
        }else{
            $candidate = votingcandidate::where('organization', Session::get('organization'))
                ->where('election_title', $election->election_title)
                ->count();
        }

        $voters = voters::where('organization', Session::get('organization'))->count();

        // return response()->json([
        //     'data' => [
        //         'position' => $position,
        //         'partylist' => $partylist,
        //         'candidate' => $candidate,
        //         'voters' => $voters
        //     ]
        // ]);

        return view('subadmin.index', [

            'label' => 'Dashboard',
            'data' => [
                'position' => $position,
                'partylist' => $partylist,
                'candidate' => $candidate,
                'voters' => $voters
            ]

        ]);

     }


    public function subadmin_position_page(){

        return view('subadmin.positions', [
            'label' => 'Position',
            'data' => votingcomponents::select('maxvote','position', 'id')
            ->where('status', 3)
            ->where('organization', session()->get('organization'))
            ->get(),
        ]);

    }

    public function subadmin_partylist_page(){


        return view('subadmin.partylist', [

            'label' => 'Party List',
            'data' => votingcomponents::select('partylist', 'id')
            ->where('status', 2)
            ->where('organization', session()->get('organization'))
            ->get(),

        ]);

    }

    public function subadmin_candidates_page() {

        $positions = votingcomponents::select('position')
        ->where('status', 3)
        ->where('organization', session()->get('organization'))
        ->distinct()
        ->get();

        $counts = [];

        foreach ($positions as $position) {
            $counts[$position->position] = votingcandidate::where('position', $position->position)->count();
        }

        return view('subadmin.candidates', [
            'label' => 'Candidates',
            'positions' => $positions,
            'counts' => $counts,
        ]);
    }

    public function subadmin_voterlist_page(){

        return view('subadmin.voter-list',[

            'label' => 'Voters',
            'data' => voters::where('organization', session()->get('organization'))
            ->get()

        ]);

    }

    public function subadmin_election_page(){

        return view('subadmin.election', [

            'label' => 'Election',
            'data' => elections::where('department', Session::get('organization'))->get()

        ]);

    }

    public function subadmin_election_type(Request $request){

        $data =  elections::where('department', session()->get('organization'))
        ->where('status', 'pending')
        ->get();

        $candidates = votingcandidate::where('organization', Session::get('organization'))->get();

        return view('subadmin.election_type',[

            'label' => 'Election Type',
            'data' => $data,
            'candidates' => $candidates

        ]);

    }

    public function to_candidate(Request $request){

        $required = elections::select('required_partylist','tbl_year')
        ->where('id', $request->id)
        ->first();

        $positions = votingcomponents::select('position')
        ->where('status', 3)
        ->where('organization', session()->get('organization'))
        ->distinct()
        ->get();

        $counts = [];

        foreach ($positions as $position) {
            $counts[$position->position] = votingcandidate::where('position', $position->position)
            ->where('election_title', $request->query('election_title'))
            ->where('election_year', $required->tbl_year)
            ->count();
        }

        return view('subadmin.candidates', [
            'label' => 'Candidates',
            'positions' => $positions,
            'counts' => $counts,
            'required' => $required->required_partylist,
            'year' => $required->tbl_year
        ]);

    }

    public function to_view_result(){

        return view('subadmin.result', [

            'label' => 'Elections',
            'data' => elections::where('department', Session::get('organization'))
                                ->get()

        ]);

    }
    

    public function subadmin_change_account(){

        return view('subadmin.update-account', [

            'label' => 'Account Details'

        ]);

    }

    // sub admin end


    // admin start

    public function admin_index_page(){

        // echo "hello world";

        return view('admin.index', [

            'label' => 'Dashboard'

        ]);

    }

     public function admin_organization_page(){
        return view('admin.organization', [

            'label' => 'Organization',
            'data' => organizations::all()

        ]);
    }

    public function admin_organization_account_page(){

        return view('admin.organization-account', [

            'label' => 'Organizations Account',
            'data' => User::select('Organization', 'name', 'id')->where('Designation', 'Subadmin ')->where('Status', 1)->get(),
            'organization' => organizations::select('organization')->get(),

        ]);

    }

    public function administrator_elections_per_org(){

        return view('admin.election_per_org',[

            'label' => 'Elections'

        ]);

    }

    public function admin_update_account(){

        return view('admin.admin_update_account', [

            'label' => 'My Account Data'

        ]);

    }

    // admin end



    //User

    public function user_index_page(){


        return view('user.index', [

            'label' => 'Dashboard'

        ]);

    }

    public function OngoingElection(Request $request){

        return view('user.OngoingElection', [

            'label' => 'Dashboard',
            'title' => $request->title

        ]);

    }

    public function user_info_page(){


        return view('user.voter-info',[

            'data' => voters::where('id', Session::get('id'))
                            ->where('organization', Session::get('organization'))
                            ->first()

        ]);

    }

    //endUser


}
