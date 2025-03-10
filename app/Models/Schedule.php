<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['title', 'law_id', 'number', 'content'];

    public function law()
    {
        return $this->belongsTo(Law::class);
    }
}
