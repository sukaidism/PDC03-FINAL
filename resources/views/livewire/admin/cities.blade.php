<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Cities</h1>
    </x-slot:header>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="overflow-x-auto">
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

            <div class="mt-4">
                {{ $cities->links() }}
            </div>
        </div>
    </div>
</div>
