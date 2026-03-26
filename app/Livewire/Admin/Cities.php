<?php

namespace App\Livewire\Admin;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;

class Cities extends Component
{
    use WithPagination;

    public function render()
    {
        $cities = City::latest()->paginate(10);

        return view('livewire.admin.cities', compact('cities'))
            ->layout('components.layouts.admin')
            ->title('Cities');
    }
}
