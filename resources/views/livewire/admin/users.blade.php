<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Users</h1>
    </x-slot:header>

    <div class="rounded-lg border border-[#19140035] bg-white">
        {{-- Toolbar: Search + Filter toggle + Export --}}
        <div class="p-4 border-b border-[#19140035] flex flex-col sm:flex-row sm:items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search users..."
                class="w-full sm:max-w-xs rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />

            <div class="flex items-center gap-2 sm:ml-auto">
                <button wire:click="$toggle('showFilters')"
                    class="inline-flex items-center gap-1.5 rounded-md border border-[#19140035] px-3 py-2 text-sm font-medium text-[#706f6c] hover:bg-[#f5f5f4] hover:text-[#1b1b18] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filters
                    @if($activeFilterCount > 0)
                        <span class="inline-flex items-center justify-center h-5 min-w-[1.25rem] rounded-full bg-black text-white text-xs font-medium px-1.5">{{ $activeFilterCount }}</span>
                    @endif
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 rounded-md border border-[#19140035] px-3 py-2 text-sm font-medium text-[#706f6c] hover:bg-[#f5f5f4] hover:text-[#1b1b18] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
                        Columns
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-1 w-44 rounded-md border border-[#19140035] bg-white shadow-lg z-50 py-1">
                        @foreach(['id' => 'ID', 'name' => 'Name', 'email' => 'Email', 'role' => 'Role', 'status' => 'Status', 'phone' => 'Phone', 'joined' => 'Joined'] as $key => $label)
                            <label class="flex items-center gap-2 px-3 py-1.5 text-sm text-[#1b1b18] hover:bg-[#f5f5f4] cursor-pointer">
                                <input type="checkbox" wire:model.live="columns.{{ $key }}"
                                    class="rounded border-[#19140035] text-black focus:ring-black focus:ring-offset-0 h-3.5 w-3.5" />
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 rounded-md bg-black px-3 py-2 text-sm font-medium text-white hover:bg-[#1b1b18]/90 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Export
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-1 w-40 rounded-md border border-[#19140035] bg-white shadow-lg z-50">
                        <button wire:click="export" @click="open = false"
                            class="flex w-full items-center gap-2 px-3 py-2 text-sm text-[#1b1b18] hover:bg-[#f5f5f4] transition-colors rounded-t-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#706f6c]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Export as CSV
                        </button>
                        <button wire:click="exportExcel" @click="open = false"
                            class="flex w-full items-center gap-2 px-3 py-2 text-sm text-[#1b1b18] hover:bg-[#f5f5f4] transition-colors rounded-b-md border-t border-[#19140035]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#706f6c]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Export as Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Advanced Filters Panel --}}
        @if($showFilters)
            <div class="p-4 border-b border-[#19140035] bg-[#f5f5f4]/50">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-[#706f6c] mb-1">Role</label>
                        <select wire:model.live="filterRole"
                            class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="renter">Renter</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#706f6c] mb-1">Status</label>
                        <select wire:model.live="filterStatus"
                            class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#706f6c] mb-1">Joined From</label>
                        <input type="date" wire:model.live="dateFrom"
                            class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#706f6c] mb-1">Joined To</label>
                        <input type="date" wire:model.live="dateTo"
                            class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
                    </div>
                </div>
                @if($activeFilterCount > 0)
                    <div class="mt-3">
                        <button wire:click="resetFilters" class="text-sm text-[#706f6c] hover:text-[#1b1b18] underline underline-offset-2">
                            Clear all filters
                        </button>
                    </div>
                @endif
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#19140035] bg-[#f5f5f4]">
                        @if($columns['id'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">
                            <button wire:click="sortBy('id')" class="inline-flex items-center gap-1 hover:text-[#1b1b18]">
                                ID
                                @if($sortBy === 'id')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" /></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                        @if($columns['name'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">
                            <button wire:click="sortBy('name')" class="inline-flex items-center gap-1 hover:text-[#1b1b18]">
                                Name
                                @if($sortBy === 'name')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" /></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                        @if($columns['email'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">
                            <button wire:click="sortBy('email')" class="inline-flex items-center gap-1 hover:text-[#1b1b18]">
                                Email
                                @if($sortBy === 'email')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" /></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                        @if($columns['role'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Role</th>
                        @endif
                        @if($columns['status'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Status</th>
                        @endif
                        @if($columns['phone'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">
                            <button wire:click="sortBy('phone')" class="inline-flex items-center gap-1 hover:text-[#1b1b18]">
                                Phone
                                @if($sortBy === 'phone')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" /></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                        @if($columns['joined'])
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">
                            <button wire:click="sortBy('created_at')" class="inline-flex items-center gap-1 hover:text-[#1b1b18]">
                                Joined
                                @if($sortBy === 'created_at')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $sortDir === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" /></svg>
                                @endif
                            </button>
                        </th>
                        @endif
                        <th class="px-4 py-3 text-left font-medium text-[#706f6c]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#19140035]">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#f5f5f4] transition-colors">
                            @if($columns['id'])
                            <td class="px-4 py-3 text-[#706f6c]">{{ $user->id }}</td>
                            @endif
                            @if($columns['name'])
                            <td class="px-4 py-3 font-medium text-[#1b1b18]">{{ $user->name }}</td>
                            @endif
                            @if($columns['email'])
                            <td class="px-4 py-3 text-[#1b1b18]">{{ $user->email }}</td>
                            @endif
                            @if($columns['role'])
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full border border-[#19140035] px-2 py-0.5 text-xs font-medium text-[#706f6c]">{{ ucfirst($user->role) }}</span>
                            </td>
                            @endif
                            @if($columns['status'])
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $user->status === 'active' ? 'bg-green-50 text-green-700' : ($user->status === 'suspended' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            @endif
                            @if($columns['phone'])
                            <td class="px-4 py-3 text-[#706f6c]">{{ $user->phone ?? '—' }}</td>
                            @endif
                            @if($columns['joined'])
                            <td class="px-4 py-3 text-[#706f6c]">{{ $user->created_at->format('M d, Y') }}</td>
                            @endif
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <button class="text-sm text-[#706f6c] hover:text-[#1b1b18]">View</button>
                                    <button class="text-sm text-[#706f6c] hover:text-[#1b1b18]">Edit</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ collect($columns)->filter()->count() + 1 }}" class="px-4 py-8 text-center text-[#706f6c]">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#19140035]">
            {{ $users->links() }}
        </div>
    </div>
</div>
