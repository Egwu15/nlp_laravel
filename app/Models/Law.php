<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Law extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'is_free',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_free' => 'boolean',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }


    public function parts(): HasManyThrough
    {
        return $this->hasManyThrough(Part::class, Chapter::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function schedule(): hasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function accessPlans()
    {
        return $this->morphToMany(AccessPlan::class, 'access_planable');
    }

}
