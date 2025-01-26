<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\organizations;

class Dataorg extends Component
{
    public function render()
    {
        $data = organizations::all();
        return view('livewire.dataorg',[

            'data' => $data

        ]);
    }
}
