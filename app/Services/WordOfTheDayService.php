<?php

namespace App\Services;

use App\Models\WordOfTheDay;
use App\Models\LegalTerm;
use Illuminate\Support\Carbon;

class WordOfTheDayService
{
    public static function getToday()
    {
        $today = Carbon::today();

        $word = WordOfTheDay::whereDate('date', $today)->first();

        if ($word) {
            return $word->term;
        }

        $randomTerm = LegalTerm::inRandomOrder()->first();

        WordOfTheDay::create([
            'legal_term_id' => $randomTerm->id,
            'date' => $today,
        ]);

        return $randomTerm;
    }
}
