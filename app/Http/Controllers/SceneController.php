<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Scene;
use App\Timecode;

class SceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scenes = Scene::orderBy('start')
                       ->get();
        return view('scenes.index', [
            'scenes' => $scenes
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
        // validate

        $scene = new Scene;
        $scene->start = Timecode::makeTimecode($request->get('start'));
        if ($request->has('end')) {
            $scene->end = Timecode::makeTimecode($request->get('end'));
        }
        $scene->name = $request->get('name');
        $scene->save();

        Cache::forget('kyntime-scenes');
        $request->session()->flash('success', 'The scene was created.');
        return redirect()->route('scenes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scene $scene)
    {
        // validate

        $scene->start = Timecode::makeTimecode($request->get('start'));
        if ($request->has('end')) {
            $scene->end = Timecode::makeTimecode($request->get('end'));
        } else {
            $scene->end = null;
        }
        $scene->name = $request->get('name');
        $scene->save();

        Cache::forget('kyntime-scenes');
        $request->session()->flash('success', 'The scene was updated.');
        return redirect()->route('scenes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Scene $scene)
    {
        $scene->delete();

        Cache::forget('kyntime-scenes');
        $request->session()->flash('success', 'The scene was deleted.');
        return redirect()->route('scenes.index');
    }
}
