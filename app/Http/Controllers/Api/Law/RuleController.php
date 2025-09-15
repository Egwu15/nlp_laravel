<?php

namespace App\Http\Controllers\Api\Law;


use App\Http\Controllers\Controller;
use App\Http\Resources\CourtRuleResource;
use App\Http\Resources\LawPartResource;
use App\Models\CourtRule;
use App\Models\Law;

class RuleController extends Controller
{
    public function index()
    {
        $courtRule = CourtRule::where('is_published', true)
            ->orderBy('title')
            ->get();
        return response()->json(["court_rule" => CourtRuleResource::collection($courtRule)]);
    }

    public function show(string $id)
    {
        $court = CourtRule::with('orders.rules')
            ->where('is_published', true)
            ->find($id);


        if (is_null($court)) {
            return response()->json(['message' => 'Law not found'], 404);
        }
        return response()->json(CourtRuleResource::make($court));
//        return response()->json(['court_rule' => $court]);

    }
}
