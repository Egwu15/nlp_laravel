<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['title', 'number', 'content', 'court_rule_id', 'order_rule_id'];


    function courtRule()
    {
        return $this->belongsTo(CourtRule::class);
    }

    function orderRule()
    {
        return $this->belongsTo(OrderRule::class);
    }
}
