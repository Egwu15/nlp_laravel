<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubscription extends Model
{

    protected $fillable = [
        'user_id',
        "starts_at",
        "ends_at",
        "is_renewing",
        'access_plan_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessPlan(): HasMany
    {
        return $this->hasMany(AccessPlan::class);
    }

}
