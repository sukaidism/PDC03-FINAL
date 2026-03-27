<div>
    <x-slot:header>
        <span class="font-medium text-foreground">Cities</span>
    </x-slot:header>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto transition-opacity duration-200" wire:loading.class="opacity-50 pointer-events-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->created_at?->format('M d, Y') ?? '—' }}</td>
                                <td>
                                    <div class="flex gap-1">
                                        <button class="btn btn-ghost btn-xs">Edit</button>
                                        <button class="btn btn-ghost btn-xs text-error">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-base-content/60">No cities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-sm text-base-content/60">
                    <span>Rows per page:</span>
                    <select wire:model.live="perPage" class="select select-bordered select-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="flex-1">
                    {{ $cities->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
