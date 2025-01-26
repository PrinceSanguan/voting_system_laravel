<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\votingcomponents;

class Subadmindashboarddata extends Component
{
    public function render()
    {
        $data = votingcomponents::select('position')
        ->where('status', 3)
        ->where('organization', session()->get('organization'))
        ->get();
        return view('livewire.subadmindashboarddata',[
            'data' => $data
        ]);
    }
}
