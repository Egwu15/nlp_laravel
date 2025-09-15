<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderRule extends Model
{
    protected $fillable = ['title', 'number', 'court_rule_id'];

    function rules(): hasMany
    {
        return $this->hasMany(Rule::class);
    }

    function courtRule(): BelongsTo
    {
        return $this->belongsTo(CourtRule::class);
    }
}
