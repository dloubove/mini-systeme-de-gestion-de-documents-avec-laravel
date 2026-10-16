<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/documents')->assertRedirect('/login');
    }

    public function test_user_can_upload_a_document(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/documents', [
            'title' => 'Rapport de stage',
            'file' => UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('documents.index'));

        $document = Document::first();
        $this->assertSame('Rapport de stage', $document->title);
        $this->assertSame($user->id, $document->user_id);
        Storage::disk('public')->assertExists($document->path);
    }

    public function test_title_is_required(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post('/documents', [
            'title' => '',
            'file' => UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors('title');

        $this->assertDatabaseCount('documents', 0);
    }

    public function test_search_filters_documents_by_title(): void
    {
        $user = User::factory()->create();
        Document::factory()->create(['title' => 'Rapport final', 'user_id' => $user->id]);
        Document::factory()->create(['title' => 'Facture mars', 'user_id' => $user->id]);

        $this->actingAs($user)
            ->get('/documents/search?query=Rapport')
            ->assertOk()
            ->assertSee('Rapport final')
            ->assertDontSee('Facture mars');
    }

    public function test_only_the_owner_can_delete_a_document(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $document = Document::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('documents.destroy', $document))
            ->assertForbidden();

        $this->assertModelExists($document);
    }
}
