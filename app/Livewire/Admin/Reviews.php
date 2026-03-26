<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    public function render()
    {
        $reviews = \App\Models\Review::latest()->paginate(10);

        return view('livewire.admin.reviews', compact('reviews'))
            ->layout('components.layouts.admin')
            ->title('Reviews');
    }
}
