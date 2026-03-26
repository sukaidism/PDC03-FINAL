<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Property Types</h1>
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
                        @forelse($propertyTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->created_at?->format('M d, Y') ?? '—' }}</td>
                                <td>
                                    <div class="flex gap-1">
                                        <button class="btn btn-ghost btn-xs">Edit</button>
                                        <button class="btn btn-ghost btn-xs text-error">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-base-content/60">No property types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $propertyTypes->links() }}
            </div>
        </div>
    </div>
</div>
