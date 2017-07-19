<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Timecode;
use App\Event;
use App\Scene;
use App\Section;

class ApiController extends Controller
{
    public function timecode()
    {
        $t = Timecode::cacheVersion();
        return response()->json(Timecode::apiVersion($t));
    }

    public function scenes()
    {
        $scenes = Cache::remember('kyntime-scenes', 120, function () {
            return Scene::orderBy('start')->get();
        });
        return response()->json($scenes);
    }

    public function sections()
    {
        $sections = Cache::remember('kyntime-sections', 120, function () {
            return Section::where('active', true)
                          ->orderBy('name')
                          ->get();
        });
        return response()->json($sections);
    }

    public function events($section_id)
    {
        $events = Event::where('active', true)
                       ->where('section_id', $section_id)
                       ->orderBy('timecode')
                       ->get();
        return response()->json($events);
    }

    public function allEvents()
    {
        $events = Cache::remember('kyntime-events', 120, function () {
            return Event::with('section')
                        ->where('active', true)
                        ->orderBy('timecode')
                        ->get();
        });
        return response()->json($events);
    }
}
