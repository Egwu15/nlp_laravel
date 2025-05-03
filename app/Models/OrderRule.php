<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderRule extends Model
{
    protected $fillable = ['title', 'number', 'court_rule_id'];

    function rules(): BelongsTo
    {
        return $this->belongsTo(Rule::class);
    }

    function courtRules(): BelongsTo
    {
        return $this->belongsTo(CourtRule::class);
    }
}
