<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Documents
            </h2>
            <a href="{{ route('documents.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                Uploader un document
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-md">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-800 rounded-md">{{ session('error') }}</div>
            @endif

            {{-- Étape 8.2 : formulaire de recherche --}}
            <form action="{{ route('documents.search') }}" method="GET" class="flex gap-2">
                <x-text-input type="text" name="query" :value="$search" class="flex-1"
                              placeholder="Rechercher un document par titre..." />
                <x-primary-button>Rechercher</x-primary-button>
                @if (filled($search))
                    <a href="{{ route('documents.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                        Réinitialiser
                    </a>
                @endif
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Titre</th>
                                <th class="px-6 py-3">Ajouté par</th>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-900">
                            @forelse ($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 font-medium">{{ $document->title }}</td>
                                    <td class="px-6 py-4">{{ $document->user->name }}</td>
                                    <td class="px-6 py-4">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('documents.show', $document) }}"
                                               class="text-indigo-600 hover:underline">Voir</a>

                                            @if ($document->user_id === auth()->id())
                                                <a href="{{ route('documents.edit', $document) }}"
                                                   class="text-yellow-600 hover:underline">Modifier</a>

                                                <form action="{{ route('documents.destroy', $document) }}" method="POST"
                                                      onsubmit="return confirm('Supprimer ce document ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        Aucun document trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $documents->links() }}
        </div>
    </div>
</x-app-layout>
