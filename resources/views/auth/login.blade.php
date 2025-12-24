<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            Selamat Datang Kembali
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Silakan login ke akun Anda
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="underline text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                Daftar di sini
            </a>
        </div>
    </form>

    <!-- Demo Accounts Info (Optional - untuk development) -->
    @if(config('app.env') === 'local')
    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Demo Accounts:</p>
        <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
            <p><strong>Superadmin:</strong> superadmin@example.com / password</p>
            <p><strong>Admin:</strong> admin@example.com / password</p>
            <p><strong>User:</strong> user@example.com / password</p>
        </div>
    </div>
    @endif
</x-guest-layout>