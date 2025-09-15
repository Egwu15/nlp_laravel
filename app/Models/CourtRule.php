<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class CourtRule extends Model
{
    protected $fillable = ['title', 'description', 'is_published', 'is_free'];

    protected $casts = ['is_published' => 'boolean', 'is_free' => 'boolean'];

    function orders(): HasMany
    {
        return $this->hasMany(OrderRule::class);
    }

    function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }

    public function accessPlans(): MorphToMany
    {
        return $this->morphToMany(AccessPlan::class, 'access_planable');
    }


}
