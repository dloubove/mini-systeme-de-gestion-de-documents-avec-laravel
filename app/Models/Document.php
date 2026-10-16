<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * Colonnes autorisées en assignation de masse (create / update).
     */
    protected $fillable = ['title', 'path', 'user_id'];

    /**
     * Un document appartient à un utilisateur (relation many-to-one).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
