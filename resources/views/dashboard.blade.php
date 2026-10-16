<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Bienvenue {{ Auth::user()->name }}, vous êtes connecté à la GED.
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('documents.index') }}" class="block p-6 bg-white shadow-sm sm:rounded-lg hover:shadow">
                    <div class="text-3xl font-bold text-gray-900">{{ $documentsCount }}</div>
                    <div class="text-sm text-gray-500">Documents au total</div>
                </a>
                <a href="{{ route('documents.index') }}" class="block p-6 bg-white shadow-sm sm:rounded-lg hover:shadow">
                    <div class="text-3xl font-bold text-gray-900">{{ $myDocumentsCount }}</div>
                    <div class="text-sm text-gray-500">Mes documents</div>
                </a>
                <a href="{{ route('users.index') }}" class="block p-6 bg-white shadow-sm sm:rounded-lg hover:shadow">
                    <div class="text-3xl font-bold text-gray-900">{{ $usersCount }}</div>
                    <div class="text-sm text-gray-500">Utilisateurs</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
