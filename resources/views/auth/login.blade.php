<x-guest-layout>
    {{-- Header Halaman Login --}}
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800">
            Selamat Datang Kembali
        </h1>
        <p class="text-sm text-slate-600 mt-1">
            Silakan masuk untuk melanjutkan ke panel admin.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email"
                          class="block mt-1 w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="password"
                          class="block mt-1 w-full border-2 border-slate-200 rounded-lg text-sm p-2 focus:outline-none focus:border-indigo-500 transition"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0"
                       name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3">
                {{ __('Log In') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>