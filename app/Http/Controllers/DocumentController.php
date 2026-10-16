<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Liste de tous les documents.
     */
    public function index(): View
    {
        $documents = Document::with('user')->latest()->paginate(10);

        return view('documents.index', ['documents' => $documents, 'search' => null]);
    }

    /**
     * Formulaire d'upload.
     */
    public function create(): View
    {
        return view('documents.create');
    }

    /**
     * Enregistre le fichier sur le disque "public" puis crée la ligne en base.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'file' => 'required|file|mimes:pdf,doc,docx,txt,png,jpg|max:2048',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Auth::user()->documents()->create([
            'title' => $request->input('title'),
            'path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document uploadé avec succès.');
    }

    /**
     * Détail d'un document.
     */
    public function show(Document $document): View
    {
        $document->load('user');

        return view('documents.show', compact('document'));
    }

    /**
     * Formulaire de modification (propriétaire uniquement).
     */
    public function edit(Document $document): View
    {
        $this->authorizeOwner($document);

        return view('documents.edit', compact('document'));
    }

    /**
     * Met à jour le titre et, éventuellement, remplace le fichier.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $this->authorizeOwner($document);

        $request->validate([
            'title' => 'required|string|max:50',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,png,jpg|max:2048',
        ]);

        $data = ['title' => $request->input('title')];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->path);
            $data['path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document mis à jour.');
    }

    /**
     * Supprime le fichier et la ligne en base (propriétaire uniquement).
     */
    public function destroy(Document $document): RedirectResponse
    {
        $this->authorizeOwner($document);

        Storage::disk('public')->delete($document->path);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document supprimé.');
    }

    /**
     * Étape 8 : recherche par titre.
     */
    public function search(Request $request): View
    {
        $search = trim((string) $request->input('query', ''));

        $documents = Document::with('user')
            ->where('title', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('documents.index', compact('documents', 'search'));
    }

    /**
     * Seul le propriétaire peut modifier ou supprimer son document.
     */
    private function authorizeOwner(Document $document): void
    {
        abort_if($document->user_id !== Auth::id(), 403);
    }
}
