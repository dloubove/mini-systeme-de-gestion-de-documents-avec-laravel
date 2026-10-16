<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GED') }} - Connexion</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

        {{-- Colonne gauche : image (masquée sur petit écran) --}}
        <div class="hidden md:block bg-gray-700 bg-cover bg-center"
             style="background-image: url('{{ asset('images/login-books.jpg') }}');">
        </div>

        {{-- Colonne droite : formulaire --}}
        <div class="flex items-center justify-center bg-slate-100 px-6 py-12">
            <div class="w-full max-w-md">

                <div class="flex justify-center mb-6">
                    <x-application-logo class="w-14 h-14 fill-current text-red-500" />
                </div>

                <h1 class="text-lg font-medium text-gray-900">
                    Bienvenue sur la plateforme de gestion de documents
                </h1>
                <h2 class="mt-3 font-semibold text-blue-600">
                    Connectez-vous !
                </h2>

                <x-auth-session-status class="mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-white" type="email"
                                      name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full bg-white" type="password"
                                      name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember me -->
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    <div class="flex items-center justify-end gap-4">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-gray-600 underline hover:text-gray-900">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
