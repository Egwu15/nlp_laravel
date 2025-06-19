<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json(UserResource::make($request->user()));
    }
}
