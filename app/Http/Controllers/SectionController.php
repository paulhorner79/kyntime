<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::orderBy('name')->get();
        return view('sections.index', [
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|string|max:255'
        ]);

        $section = new Section;
        $section->name = $request->get('name');
        $section->active = true;
        $section->save();

        Cache::forget('kyntime-sections');
        $request->session()->flash('success', 'The section was created.');
        return redirect()->route('sections.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $this->validate($request, [
            'name'  => 'required|string|max:255'
        ]);

        $section->name = $request->get('name');
        $section->active = $request->has('active');
        $section->save();

        Cache::forget('kyntime-sections');
        $request->session()->flash('success', 'The section was updated.');
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Section $section)
    {
        foreach ($section->events as $event) {
            $event->delete();
        }
        $section->delete();

        Cache::forget('kyntime-sections');
        $request->session()->flash('success', 'The section was deleted.');
        return redirect()->route('sections.index');
    }
}
