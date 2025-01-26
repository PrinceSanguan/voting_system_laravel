<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Voter; // Assuming the model is Voter
use App\Models\Ballot;

class Realtimevotersdata extends Component
{
    public $votersList = []; // To store and display the voters
    public $selectoption;

    public function handleChange($value)
    {
        $ballot = Ballot::orderby('id', 'desc')->first();

        // Fetch users who voted
        $user_voted = Ballot::select('fingerprint')
            ->where('election_year', $ballot->election_year)
            ->where('election_title', $ballot->election_title)
            ->get()
            ->unique('fingerprint');

        $voted = [];
        $not_voted = [];

        // Fetch all voters
        $voters = Voter::select('fingerprint', 'first_name', 'age')->get()->unique('fingerprint');

        foreach ($voters as $voter) {
            $isVoted = false;
            foreach ($user_voted as $userVote) {
                if ($voter->fingerprint == $userVote->fingerprint) {
                    $isVoted = true;
                    break;
                }
            }

            if ($isVoted) {
                $voted[] = [
                    'first_name' => $voter->first_name,
                    'age'        => $voter->age,
                    'status'     => 'Voted',
                ];
            } else {
                $not_voted[] = [
                    'first_name' => $voter->first_name,
                    'age'        => $voter->age,
                    'status'     => 'Not Voted',
                ];
            }
        }

        switch ($value) {
            case 'voted':
                $this->votersList = $voted;
                break;
            case 'not voted':
                $this->votersList = $not_voted;
                break;
            default:
                $this->votersList = $voters->map(function ($voter) {
                    return [
                        'first_name' => $voter->first_name,
                        'age'        => $voter->age,
                        'status'     => 'All',
                    ];
                })->toArray();
                break;
        }
    }

    public function render()
    {
        return view('livewire.realtimevotersdata');
    }
}
