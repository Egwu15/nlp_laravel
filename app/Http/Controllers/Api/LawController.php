<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LawPartResource;
use App\Http\Resources\LawResource;
use App\Models\Law;
use Illuminate\Http\Request;

class LawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $law = Law::where('is_published', true)
            ->orderBy('title')
            ->get();
        return response()->json(['laws' => LawResource::collection($law)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $law = Law::where('is_published', true)
            ->with(['chapters.parts.sections', 'category', 'schedule'])->find($id);


        if (is_null($law)) {
            return response()->json(['message' => 'Law not found'], 404);
        }
        return response()->json(LawPartResource::make($law));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
