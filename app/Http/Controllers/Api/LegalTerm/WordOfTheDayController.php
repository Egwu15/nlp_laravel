<?php

namespace App\Http\Controllers\Api\LegalTerm;

use App\Http\Controllers\Controller;
use App\Models\WordOfTheDay;
use App\Services\WordOfTheDayService;
use Illuminate\Support\Carbon;

class WordOfTheDayController extends Controller
{

    public function showToday()
    {
        $term = WordOfTheDayService::getToday();
        return response()->json([
            'term' => $term->term,
            'definition' => $term->definition,
            'date' => Carbon::today(),
        ]);
    }

    public function showMonthly()
    {
        $terms = WordOfTheDayService::allTimeWords();
        return response()->json([
            'terms' => $terms,
        ]);
    }


}
