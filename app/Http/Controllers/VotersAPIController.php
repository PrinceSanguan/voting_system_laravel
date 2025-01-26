<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Voters;
use App\Models\elections;
use Illuminate\Support\Facades\Http;

class VotersAPIController extends Controller
{

    public function verifyOTP(Request $request){

        $exists = voters::where('id', $request->id)->where('otp', $request->otp)->exists();

        if ($exists) {
            return response()->json([
                'response' => true
            ]);
        }else{
            return response()->json([
                'response' => false
            ]);
        }
    }

    public function sms($exist){

        $apiKey = env('TEXTBEE_API_KEY');
        $deviceId = env('TEXTBEE_DEVICE_ID');
        $random = rand(1000, 9999);

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->post("https://api.textbee.dev/api/v1/gateway/devices/{$deviceId}/sendSMS", [
            'recipients' => [$exist->phone_number],
            'message' => 'Your OTP: '.$random,
        ]);

        if ($response->successful()) {

            Voters::where('id', $exist->id)->update([
                'otp' => $random
            ]);
            return response()->json([
                'response' => 1,
                'data' => $exist
            ]);

        } else {
            return response()->json(['error' => 'Failed to send SMS.']);
        }
    }

    public function verifylogin(Request $request){
        
        $exist= Voters::where('email', $request->email)->where('pin', $request->pin)->first();
        $exists= Voters::where('email', $request->email)->where('pin', $request->pin)->exists();
        
        if (!$exists) {
            return response()->json([
                'response' => 2,
                'message' => 'Incorrect Email or Pin'
            ]);
        }

        if ($exist->status == 'registered') {
            return $this->sms($exist);
        }else{
            return response()->json([
                'response' => 3,
                'data' => $exist
            ]);
        }
    }

    public function updateaccount(Request $request){
        
        $update = voters::where('id', $request->id)->update([
            'device_id' => $request->device,
            'pin' => $request->pin,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'course' => $request->course,
            'year_lvl' => $request->year_lvl,
            'phone_number' => $request->phone_number,
            'status' => 'registered'
        ]);

        if ($update) {
            return response()->json([
                'response' => 1,
                'message' => 'Account Updated'
            ]);
        }

    }

    public function verifyFingerprint(Request $request){

        $exist = Voters::where('device_id', $request->device)->first();

        if ($exist && $exist->status == 'registered') {
            return $this->sms($exist);
            // return response()->json([
            //     'response' => 1,
            //     'data' => $exist
            // ]);
        }

    }
}
