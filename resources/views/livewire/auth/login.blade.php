<div>
    <div class="w-full max-w-sm">
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-md bg-black">
                <span class="text-lg font-bold text-white">L</span>
            </div>
            <h1 class="text-xl font-semibold text-[#1b1b18]">Sign in to your account</h1>
            <p class="mt-1 text-sm text-[#706f6c]">Admin panel access only</p>
        </div>

        <form wire:submit="login" class="space-y-4">
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-[#1b1b18] mb-1.5">Email</label>
                <input id="email" type="email" wire:model="email" placeholder="admin@example.com"
                    class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('email') border-red-500 @enderror" />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-[#1b1b18] mb-1.5">Password</label>
                <input id="password" type="password" wire:model="password" placeholder="Enter your password"
                    class="w-full rounded-md border border-[#19140035] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:border-black focus:outline-none focus:ring-1 focus:ring-black @error('password') border-red-500 @enderror" />
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2">
                <input id="remember" type="checkbox" wire:model="remember"
                    class="h-4 w-4 rounded border-[#19140035] text-black focus:ring-black" />
                <label for="remember" class="text-sm text-[#706f6c]">Remember me</label>
            </div>

            {{-- Submit --}}
            <button type="submit" wire:loading.attr="disabled"
                class="w-full rounded-md bg-black px-4 py-2.5 text-sm font-medium text-white hover:bg-black/90 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 disabled:opacity-50 transition-colors">
                <span wire:loading.remove>Sign In</span>
                <span wire:loading class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Signing in...
                </span>
            </button>
        </form>
    </div>
</div>
