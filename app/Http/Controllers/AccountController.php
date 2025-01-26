<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\voters;
use App\Models\elections;
use App\Models\ballot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Http;


class AccountCOntroller extends Controller
{
    public function changepass(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required|string',
            'newpassword' => 'required|string|min:8|digits:8|different:password', // Ensure new password is 8 numeric digits
        ]);
    
        // Find the user by ID
        $user = User::find($request->id);
    
        if (!$user) {
            return back()->with([
                'changed' => 2,
                'changed_message' => 'User not found.',
            ]);
        }
    
        // Verify the old password
        try {
            $storedPassword = Crypt::decryptString($user->pin);
            if ($request->password !== $storedPassword) {
                return back()->with([
                    'changed' => 2,
                    'changed_message' => 'Incorrect old password, please try again.',
                ]);
            }
        } catch (\Exception $e) {
            // Handle decryption errors
            return back()->with([
                'changed' => 2,
                'changed_message' => 'Unable to verify the current password. Please contact support.',
            ]);
        }
    
        // Update with the new encrypted password
        $user->pin = Crypt::encryptString($request->newpassword);
        $user->save();
    
        return back()->with([
            'changed' => 1,
            'changed_message' => 'Password changed successfully!',
        ]);
    }
    
    
    public function reg_admin(Request $request){

        $exist = User::where('Designation', 'administrator')->exists();

        if ($exist) {
            return back()->with([

                'response' => 2,
                'message' => 'administrator is already exist '

            ]);
        }

        User::create([

            'fingerprint' => $request->fingerprint,
            'Designation' => 'administrator',
            'Status' => 1

        ]);


        return back()->with([

            'response' => 1,
            'message' => 'Administrator account created successfully'

        ]);


    }
    public function LoginVerification(Request $request){

        $request->validate([
            'email' => 'required|email',
            'pin' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with([
                'response' => 2,
                'message' => 'Credentials did not match'
            ]);
        }

        $decrypt = Crypt::decryptString($user->pin);

        if ($decrypt == $request->pin) {
            Session::put([
                'id' => $user->id,
                'organization' => $user->Organization,
                'Designation' => $user->Designation
            ]);

            if ($user->Designation == 'administrator') {
                return redirect()->route('admin.index');
            }else{
                return to_route('subadmin.index');
            }
            
        }else{
            return back()->with([
                'response' => 2,
                'message' => 'Incorrect Username or PIN'
            ]);
        }
    }
    
    public function ChangePassword(Request $request){
        $name = session()->get('Name');
        $data = user::where('name', $name)->first();

        if(Hash::check($request->CurrentPassword, $data->password)){
            $data->password = Hash::make($request->Password);
            $data->save();
            Session::flash('messageSuccess', "Password Has Change Successfuly");
            return back();
        }else{
            Session::flash('messageError', "Current Password is Incorrect");
            return back();
        }

    }

    public function logout()
    {
        // $request->session()->invalidate();
        Session::flush();
        return redirect('/admin');
    }

     public function register_voter(Request $request){


        try {

            $data = $request->all();
            $data["status"] = "registered";
            unset($data["_token"]);

            $exists = voters::where('fingerprint', $request->fingerprint)
            ->where('status', 'registered')
            ->exists();

            if ($exists) {

                return back()->with([

                    'response' => 2,
                    'message' => 'This Token is already Registered'

                ]);

            }

            voters::where('fingerprint', $data["fingerprint"])
            ->update($data);

            return back()->with([

                'response' => 1,
                'message' => 'New User Account Activated'

            ]);


        } catch (Exception $e) {
            
        }

    }

    public function webview(Request $request){

        $user = voters::where('id', $request->id)->first();
        if (!$user) {
            return response()->json([
                'Error Message:' => 'No user found'
            ]);
        }

        $data = elections::select('election_title','tbl_year')
        ->where('department', $request->organization)
        ->where('status', 'started')
        ->first();

        if (!$data) {
            // Session::put([
            //     'isStared' => false,
            //     'message' => 'No Election Started'
            // ]);
            Session::put([
                'logout' => 2,
                'hasVoting' => 2,
                'id' => $user->id,
                'organization' => $user->organization,
                'message' => 'No Election Started',
                'otp' => 'valid'
            ]);
            return redirect('user/dashboard');
        }


        $voter_exist = ballot::where('election_year', $data->tbl_year)
        ->where('election_title', $data->election_title)
        ->where('fingerprint', $request->id)
        ->exists();
        
        Session::put([
            'otp' => 'valid',
            'hasVoting' => true,
            'id' => $request->id,
            'organization' => $request->organization,
            'election_title' => $data->election_title,
            'election_year' => $data->tbl_year,
            'isVoted' => $voter_exist

        ]);
        
        return redirect('user/dashboard');
        
    }


    public function auth_login(Request $request){

        $user = voters::where('email', $request->email)
        ->where('pin', $request->pin)
        ->where('organization', $request->organization)
        ->first();

        if (!$user) {
            return back()->with([
                'response' => 2,
                'message' => 'Unauthorized or Incorrect username or password'
            ]);
        }

        if ($user->status != 'registered') {
            return back()->with([
                'response' => 2,
                'message' => 'This user is not registered, please register on your mobile phone first'
            ]);
        }

        $data = elections::select('election_title','tbl_year')
        ->where('department', $user->organization)
        ->where('status', 'started')
        ->first();

        // return response()->json([
        //     'data' => $data
        // ]);

        if (!$data) {
            Session::put([
                'logout' => 1,
                'id' => $user->id,
                'organization' => $user->organization
            ]);
            return $this->sms($user);
        }

        $voter_exist = ballot::where('election_year', $data->tbl_year)
        ->where('election_title', $data->election_title)
        ->where('id', $user->id)
        ->count();
        
        Session::put([
            'id' => $user->id,
            'organization' => $user->organization,
            'election_title' => $data->election_title,
            'election_year' => $data->tbl_year,
            'voter_exist' => $voter_exist,
            'logout' => 1
        ]);  
        
        return $this->sms($user);

    }

    public function sms($user){

        $apiKey = env('TEXTBEE_API_KEY');
        $deviceId = env('TEXTBEE_DEVICE_ID');
        $random = rand(1000, 9999);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->post("https://api.textbee.dev/api/v1/gateway/devices/{$deviceId}/sendSMS", [
            'recipients' => [$user->phone_number],
            'message' => 'Your OTP: '.$random,
        ]);

        if ($response->successful()) {

            Voters::where('id', $user->id)->update([
                'otp' => $random
            ]);
            return redirect('otp');

        } else {
            return response()->json(['error' => 'Failed to send SMS.']);
        }

    }

    public function user_logout(Request $request){

        // $request->session()->invalidate();
        Session::flush();
        return redirect('/');

    }
}
