@php
    $redirectTo = request('redirect_to');
@endphp

<x-guest-layout>
    <a
        href="{{ route('auth.google.redirect', $redirectTo ? ['redirect_to' => $redirectTo] : []) }}"
        class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
    >
        Cadastrar com Google
    </a>

    <div class="my-4 flex items-center gap-3 text-xs uppercase text-gray-400">
        <span class="h-px flex-1 bg-gray-200"></span>
        ou
        <span class="h-px flex-1 bg-gray-200"></span>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if($redirectTo)
            <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nome" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="E-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Senha" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar senha" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login', $redirectTo ? ['redirect_to' => $redirectTo] : []) }}">
                Já tem conta?
            </a>

            <x-primary-button class="ms-4">
                Criar conta
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
