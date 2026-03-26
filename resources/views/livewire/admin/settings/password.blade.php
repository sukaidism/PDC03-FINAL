<x-layouts.settings>
    <div class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-[#1b1b18]">Update Password</h2>
            <p class="mt-1 text-sm text-[#706f6c]">Ensure your account is using a long, random password to stay secure.</p>
        </div>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-[#1b1b18]">Current Password</label>
                <input type="password" id="current_password" wire:model="current_password" autocomplete="current-password"
                    class="mt-1 block w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-[#1b1b18]">New Password</label>
                <input type="password" id="password" wire:model="password" autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[#1b1b18]">Confirm Password</label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation" autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black" />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:bg-[#1b1b18]/90 transition-colors focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                    Save
                </button>

                <div wire:loading wire:target="save" class="text-sm text-[#706f6c]">Saving...</div>

                @if (session('success'))
                    <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="text-sm text-green-600">
                        Saved.
                    </p>
                @endif
            </div>
        </form>
    </div>
</x-layouts.settings>
