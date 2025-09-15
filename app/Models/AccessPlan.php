<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class AccessPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'active',
        'price',
        'duration_days',
        'discount_price',
        'discount_expires_at',
        'google_product_id'
    ];


    public function laws(): MorphToMany
    {
        return $this->morphedByMany(Law::class, 'access_planable');
    }

    public function courtRules(): MorphToMany
    {
        return $this->morphedByMany(CourtRule::class, 'access_planable');
    }
}
