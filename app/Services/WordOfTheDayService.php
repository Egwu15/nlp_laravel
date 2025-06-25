<?php

namespace App\Services;

use App\Models\WordOfTheDay;
use App\Models\LegalTerm;
use Illuminate\Database\Eloquent\Collection;
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


    public static function allTimeWords(): collection|WordOfTheDay
    {
        $monthDays = 30;
        return WordOfTheDay::select(['date', 'legal_term_id'])->with(['term:id,term,definition'])->latest()->limit($monthDays)->get();
    }
}
