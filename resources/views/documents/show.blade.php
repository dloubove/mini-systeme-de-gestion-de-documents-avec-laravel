<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $document->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg space-y-4 text-sm text-gray-900">
                <p><span class="font-semibold">Titre :</span> {{ $document->title }}</p>
                <p><span class="font-semibold">Ajouté par :</span> {{ $document->user->name }}</p>
                <p><span class="font-semibold">Date :</span> {{ $document->created_at->format('d/m/Y H:i') }}</p>

                {{-- Nécessite : php artisan storage:link --}}
                <a href="{{ asset('storage/' . $document->path) }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Ouvrir le fichier
                </a>
                <a href="{{ route('documents.index') }}" class="ml-4 text-gray-600 hover:underline">Retour à la liste</a>
            </div>
        </div>
    </div>
</x-app-layout>
