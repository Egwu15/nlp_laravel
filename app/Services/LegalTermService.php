<?php

namespace App\Services;

use App\Models\LegalTerm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class LegalTermService
{
    public static function searchLegalTerm(string $word): Collection
    {
        /**@var Collection $terms */
        $terms = LegalTerm::where('term', 'like', "%{$word}%")
            ->limit(9)
            ->get();

        return $terms;
    }
}
