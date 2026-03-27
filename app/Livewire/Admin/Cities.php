<?php

namespace App\Livewire\Admin;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;

class Cities extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $cities = City::latest()->paginate($this->perPage);

        return view('livewire.admin.cities', compact('cities'))
            ->layout('components.layouts.admin')
            ->title('Cities');
    }
}
