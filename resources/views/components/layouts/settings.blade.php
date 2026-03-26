<div>
    <x-slot:header>
        <h1 class="text-lg font-semibold text-[#1b1b18]">Settings</h1>
    </x-slot:header>

    {{-- Settings tab navigation --}}
    <div class="mb-6">
        <nav class="flex gap-1 border-b border-[#19140035]">
            <a href="{{ route('admin.settings.profile') }}" wire:navigate
                class="relative px-4 py-2.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.settings.profile') ? 'text-[#1b1b18]' : 'text-[#706f6c] hover:text-[#1b1b18]' }}">
                Profile
                @if(request()->routeIs('admin.settings.profile'))
                    <span class="absolute inset-x-0 -bottom-px h-0.5 bg-black"></span>
                @endif
            </a>
            <a href="{{ route('admin.settings.password') }}" wire:navigate
                class="relative px-4 py-2.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.settings.password') ? 'text-[#1b1b18]' : 'text-[#706f6c] hover:text-[#1b1b18]' }}">
                Password
                @if(request()->routeIs('admin.settings.password'))
                    <span class="absolute inset-x-0 -bottom-px h-0.5 bg-black"></span>
                @endif
            </a>
            <a href="{{ route('admin.settings.delete') }}" wire:navigate
                class="relative px-4 py-2.5 text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.settings.delete') ? 'text-[#1b1b18]' : 'text-[#706f6c] hover:text-[#1b1b18]' }}">
                Delete Account
                @if(request()->routeIs('admin.settings.delete'))
                    <span class="absolute inset-x-0 -bottom-px h-0.5 bg-black"></span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Settings content --}}
    <div class="max-w-2xl">
        {{ $slot }}
    </div>
</div>
