<?php

namespace App\Livewire\Admin;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class Reservations extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $reservations = Reservation::query()
            ->when($this->search, fn ($q) => $q->whereHas('property', fn ($pq) => $pq->where('title', 'like', "%{$this->search}%")))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.reservations', compact('reservations'))
            ->layout('components.layouts.admin')
            ->title('Reservations');
    }
}
