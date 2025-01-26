<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\organization;

class Organization extends Component
{
    public function render()
    {
        $data = organization::all();
        return view('livewire.organization',[

            'data' => $data

        ]);
    }
}
