<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description'
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }


    public function parts()
    {
        return $this->hasManyThrough(Part::class, Chapter::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function schedule()
    {
        $this->hasMany(Schedule::class);
    }
}
