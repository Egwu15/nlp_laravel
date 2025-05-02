<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Chapter extends Model
{
    protected $fillable = ['title', 'law_id', 'number'];

    public function law(): Relations\BelongsTo
    {
        return $this->belongsTo(Law::class);
    }

    public function parts(): Relations\HasMany|Chapter
    {
        return $this->hasMany(Part::class);
    }
}
