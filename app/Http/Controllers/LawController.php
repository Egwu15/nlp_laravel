<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Law;
use App\Models\Part;

class LawController extends Controller
{
    public function laws()
    {
        $laws = Law::all();
        $laws = Law::orderBy('title')->get();

        return Inertia::render('Law/ViewLaws', ['laws' => $laws]);
    }

    public function chapters(Law $law)
    {
        $chapters = $law->chapters()->orderBy('title')->get();
        return Inertia::render('Law/ViewChapters', ['chapters' => $chapters, 'law' => $law]);
    }

    public function parts(Chapter $chapter)
    {
        $part = Part::where('chapter_id', $chapter->id)->get();
        $law = Law::where('id', $chapter->law_id)->first();
        return Inertia::render('Law/ViewParts', ['parts' => $part, 'chapter' => $chapter, 'law' => $law]);
    }

    public function sections(Part $part)
    {
        $sections = $part->sections()->orderBy('number')->get();
        $chapter = Chapter::where('id', $part->chapter_id)->first();
        $law = Law::where('id', $chapter->law_id)->first();
        return Inertia::render('Law/ViewSections', ['sections' => $sections, 'part' => $part, 'chapter' => $chapter, 'law' => $law]);
    }
}
   
