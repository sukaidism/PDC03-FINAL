<?php

namespace App\Livewire\Admin;

use App\Models\PropertyType;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyTypes extends Component
{
    use WithPagination;

    public function render()
    {
        $propertyTypes = PropertyType::latest()->paginate(10);

        return view('livewire.admin.property-types', compact('propertyTypes'))
            ->layout('components.layouts.admin')
            ->title('Property Types');
    }
}
