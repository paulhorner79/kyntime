<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Section;
use App\Event;
use App\Timecode;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Section $section)
    {
        $events = Event::where('section_id', $section->id)
                       ->orderBy('name')
                       ->get();
        return view('events.index', [
            'section' => $section,
            'events'  => $events
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Section $section)
    {
        // validate

        $event = new Event;
        $event->section_id = $section->id;
        $event->timecode = Timecode::makeTimecode($request->get('timecode'));
        $event->name = $request->get('name');
        $event->notes = $request->get('notes');
        $event->active = true;
        $event->save();

        Cache::forget('kyntime-events');
        $request->session()->flash('success', 'The event was created.');
        return redirect()->route('sections.events.index', $section->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section, Event $event)
    {
        // validate

        $event->timecode = Timecode::makeTimecode($request->get('timecode'));
        $event->name = $request->get('name');
        $event->active = $request->has('active');
        $event->notes = $request->get('notes');
        $event->save();

        Cache::forget('kyntime-events');
        $request->session()->flash('success', 'The event was updated.');
        return redirect()->route('sections.events.index', $section->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Section $section, Event $event)
    {
        $event->delete();

        Cache::forget('kyntime-events');
        $request->session()->flash('success', 'The event was deleted.');
        return redirect()->route('sections.events.index', $section->id);
    }
}
