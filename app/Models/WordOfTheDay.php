<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordOfTheDay extends Model
{
    protected $fillable = ['legal_term_id', 'date'];

    public function term(): BelongsTo
    {
        return $this->belongsTo(LegalTerm::class, 'legal_term_id');
    }
}
