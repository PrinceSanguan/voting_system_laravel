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

    // Retrieve voter ID (assuming it's stored in the session)
    $voterId = Session::get('id');

    if (!$voterId) {
        return back()->with([
            'response' => 0,
            'message' => 'Voter not authenticated!'
        ]);
    }

    foreach ($data as $key => $value) {
        $candidate = votingcandidate::where('id', $value)->first();

        if ($candidate) {
            // Increment the vote count
            $candidate->vote += 1;
            $candidate->save();

            // Save the vote in the ballot table
            $model = new ballot;
            $model->fingerprint = $voterId;
            $model->voted_candidates = $value;
            $model->election_title = Session::get('election_title');
            $model->election_year = Session::get('election_year');
            $model->organization = Session::get('organization');
            $model->save();

            // Add updated candidate data to the response array
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

    

    // Return a response or redirect back
    return back()->with([
        'response' => 1,
        'message' => 'Vote submitted successfully!',
        'updated_data' => $dataArray
    ]);
}


    public function update_data(Request $request)
{
    // Retrieve all form data
    $data = $request->all();

    // Remove CSRF token from the data
    unset($data["_token"]);

    // Get the specific voter using their ID (passed as hidden input in the form)
    $voter_id = $request->input('voter_id'); // Assuming you are passing 'voter_id' from the form

    // Find the voter by their ID (use the specific voter)
    $voter = voters::find($voter_id);

    // Check if the voter exists
    if ($voter) {
        // Validate the PIN length (example: PIN should be exactly 8 characters)
        $pin = $request->input('pin');
        if (!is_numeric($pin) || strlen($pin) != 8) { // Adjust this to your desired length
            return back()->with([
                'response' => 'pin_error',
                'message' => 'The PIN must be at exactly 8 numeric digits.'
            ]);
        }

        // Update the voter's data
        $update = $voter->update($data);

        // Check if the update was successful
        if ($update) {
            return back()->with([
                'response' => 'success',
                'message' => 'Account updated successfully!'
            ]);
        } else {
            return back()->with([
                'response' => 'failure',
                'message' => 'Failed to update account. Please try again.'
            ]);
        }
    } else {
        // If the voter is not found, return an error response
        return back()->with([
            'response' => 'voter_not_found',
            'message' => 'Voter not found!'
        ]);
    }
}


}
