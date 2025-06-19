<?php

namespace App\Http\Controllers\Api\LegalTerm;

use App\Http\Controllers\Controller;
use App\Services\WordOfTheDayService;
use Illuminate\Support\Carbon;

class WordOfTheDayController extends Controller
{

    public function __invoke()
    {
        $term = WordOfTheDayService::getToday();
        return response()->json([
            'term' => $term->term,
            'definition' => $term->definition,
            'date' => Carbon::today(),
        ]);
    }
}
