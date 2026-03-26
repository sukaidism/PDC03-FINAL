<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Reservations</h1>
    </x-slot:header>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search reservations..."
                    class="input input-bordered w-full sm:max-w-xs" />
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Property</th>
                            <th>Move In</th>
                            <th>Move Out</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->property->title ?? 'N/A' }}</td>
                                <td>{{ $reservation->move_in_date }}</td>
                                <td>{{ $reservation->move_out_date ?? '—' }}</td>
                                <td>{{ number_format($reservation->total_price, 2) }}</td>
                                <td>
                                    @php
                                        $colors = ['pending' => 'badge-warning', 'confirmed' => 'badge-success', 'cancelled' => 'badge-error', 'completed' => 'badge-info'];
                                    @endphp
                                    <span class="badge {{ $colors[$reservation->status] ?? 'badge-ghost' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-xs">View</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-base-content/60">No reservations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>
