<?php

namespace App\Models;

use App\Enums\AppPlatForms;
use Illuminate\Database\Eloquent\Model;

class AppForceUpDate extends Model
{
    protected $fillable = [
        'platform',
        'app_min_version',
        'app_latest_version',
        'update_message',
    ];

    protected $casts = [
        'platform' => AppPlatForms::class,
    ];


}
