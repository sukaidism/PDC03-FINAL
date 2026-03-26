<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Properties</h1>
    </x-slot:header>

    <div class="rounded-lg border border-[#19140035] bg-white">
        <div class="p-4 border-b border-[#19140035]">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search properties..."
                class="w-full sm:max-w-xs rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#19140035] bg-[#f5f5f4]">
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">ID</th>
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Title</th>
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Created</th>
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#19140035]">
                    @forelse($properties as $property)
                        <tr class="hover:bg-[#f5f5f4] transition-colors">
                            <td class="px-4 py-3 text-[#706f6c]">{{ $property->id }}</td>
                            <td class="px-4 py-3 font-medium text-[#1b1b18]">{{ $property->title }}</td>
                            <td class="px-4 py-3 text-[#1b1b18]">{{ number_format($property->price, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $property->status ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $property->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#706f6c]">{{ $property->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button class="text-sm text-[#706f6c] hover:text-[#1b1b18]">View</button>
                                    <button class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Edit</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[#706f6c]">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#19140035]">
            {{ $properties->links() }}
        </div>
    </div>
</div>
