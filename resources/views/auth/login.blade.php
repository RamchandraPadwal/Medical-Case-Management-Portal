<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Clinical Staff Login</h2>
        <p class="text-xs text-slate-500 mt-1">Sign in to access implant cases and clinical dashboard</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-sm text-rose-700 font-medium flex items-center gap-2.5">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first('email') ?: $errors->first('password') ?: __('Invalid email or password. Please try again.') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                          placeholder="doctor@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                <span class="ms-2 text-xs text-slate-600">{{ __('Remember me on this workstation') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-xs text-slate-500 hover:text-slate-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5">
                {{ __('Sign In to Portal') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Reviewer Demo Credentials Helper Box -->
    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
        <div class="font-bold text-slate-700 flex items-center gap-1.5 mb-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Reviewer Demo Accounts
        </div>
        <div class="space-y-1.5 text-slate-600">
            <div class="flex justify-between items-center py-1 border-b border-slate-200/60">
                <span><strong>Admin</strong>: <code class="text-teal-700">admin@example.com</code></span>
                <span class="text-slate-500 font-mono">password</span>
            </div>
            <div class="flex justify-between items-center py-1">
                <span><strong>Viewer</strong>: <code class="text-slate-700">viewer@example.com</code></span>
                <span class="text-slate-500 font-mono">password</span>
            </div>
        </div>
    </div>
</x-guest-layout>
