<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg space-y-3 text-sm text-gray-900">
                <p><span class="font-semibold">Nom :</span> {{ $user->name }}</p>
                <p><span class="font-semibold">E-mail :</span> {{ $user->email }}</p>
                <p><span class="font-semibold">Documents :</span> {{ $user->documents_count }}</p>
                <p><span class="font-semibold">Inscrit le :</span> {{ $user->created_at->format('d/m/Y') }}</p>
                <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">Retour à la liste</a>
            </div>
        </div>
    </div>
</x-app-layout>
