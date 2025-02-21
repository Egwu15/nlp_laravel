<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['content', 'number', 'part_id', 'law_id'];


    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    protected static function booted()
    {
        static::saving(function ($section) {
            if ($section->part && $section->part->chapter && $section->part->chapter->law) {
                $section->law_id = $section->part->chapter->law->id;
            }
        });
    }

    public function law()
    {
        return $this->belongsTo(Law::class);
    }
}
