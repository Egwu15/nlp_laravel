<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = ['title', 'law_id', 'number', 'content'];

    public function law(): BelongsTo
    {
        return $this->belongsTo(Law::class);
    }
}
