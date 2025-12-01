<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-pet-orange-500 via-pet-orange-400 to-pet-green-500 bg-clip-text text-transparent">
                ¡Bienvenido!
            </h2>
            <p class="text-sm text-pet-orange-700/70 mt-1">Inicia sesión en tu cuenta</p>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-pet-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-pet-orange-900/80" />
                <x-input id="email" class="block mt-1 w-full border-pet-orange-200 focus:border-pet-orange-400 focus:ring-pet-orange-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-pet-orange-900/80" />
                <x-input id="password" class="block mt-1 w-full border-pet-orange-200 focus:border-pet-orange-400 focus:ring-pet-orange-400" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-pet-orange-900/70">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-pet-orange-700 hover:text-pet-orange-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pet-orange-400" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4 bg-gradient-to-r from-pet-orange-500 to-pet-green-500 hover:from-pet-orange-600 hover:to-pet-green-600 text-white border-0 shadow-lg">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
