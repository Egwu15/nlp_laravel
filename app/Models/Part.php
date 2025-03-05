<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['title', 'chapter_id', 'number'];
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function law()
    {
        return $this->chapter->law();
    }

}
