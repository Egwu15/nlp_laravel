<?php

namespace App\Http\Controllers\Api\LegalTerm;

use App\Http\Controllers\Controller;
use App\Http\Resources\LegalTermResource;
use App\Services\LegalTermService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LegalTermController extends Controller
{
    public function searchLegalTerm(string $keyword)
    {
        $term = LegalTermService::searchLegalTerm($keyword);
        return response()->json(['terms' => LegalTermResource::collection($term)]);
    }
}
