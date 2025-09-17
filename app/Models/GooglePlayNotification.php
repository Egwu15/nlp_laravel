<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GooglePlayNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_token',
        'product_id',
        'notification_type',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

}
