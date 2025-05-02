<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourtRule extends Model
{
    protected $fillable = ['title', 'description'];

    function orders()
    {
        return $this->hasMany(OrderRule::class);
    }

    function rules()
    {
        return $this->hasMany(Rule::class);
    }


}
