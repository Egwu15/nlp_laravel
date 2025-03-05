<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['title', 'law_id', 'number'];
    public function law()
    {
        return $this->belongsTo(Law::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
