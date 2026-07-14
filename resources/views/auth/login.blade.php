@php
    $redirectTo = request('redirect_to');
@endphp

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <a
        href="{{ route('auth.google.redirect', $redirectTo ? ['redirect_to' => $redirectTo] : []) }}"
        class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
    >
        Entrar com Google
    </a>

    <div class="my-4 flex items-center gap-3 text-xs uppercase text-gray-400">
        <span class="h-px flex-1 bg-gray-200"></span>
        ou
        <span class="h-px flex-1 bg-gray-200"></span>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if($redirectTo)
            <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
        @endif

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="E-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Senha" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Lembrar de mim</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register', $redirectTo ? ['redirect_to' => $redirectTo] : []) }}">
                Criar conta
            </a>

            <div class="flex items-center gap-3">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Esqueceu a senha?
                    </a>
                @endif

                <x-primary-button>
                    Entrar
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
