<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppForceUpDate;
use Illuminate\Http\Request;

class AppForceUpdateController extends Controller
{
    public function __invoke($platform)
    {
        $version = AppForceUpdate::where('platform', $platform)->latest()->first();

        if (is_null($version)) {
            return response()->json(['message' => 'Version not found'], 404);
        }
        return response()->json($version);
    }
}
