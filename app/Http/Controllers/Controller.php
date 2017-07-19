<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Timecode;
use App\Scene;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard()
    {
        // get cached version of timecode
        $timecode = Cache::get('kyntime-timecode', function () {
            return Timecode::orderBy('timecode')->first();
        });
        return view('dashboard', ['timecode' => $timecode]);
    }

    public function clearTimecode(Request $request)
    {
        foreach (Timecode::all() as $t) {
            $t->delete();
        }
        // clear cached version.
        Cache::forget('kyntime-timecode');
        $request->session()->flash('success', 'The timecode was cleared.');
        return redirect()->route('timecode');
    }

    public function setTimecode(Request $request)
    {
        if ($timecode = Timecode::first()) {
            $request->session()->flash('danger', 'Please clear the timecode before adding a new one.');
            return redirect()->route('timecode');
        }

        $timecode = new Timecode;
        $timecode->timecode = Timecode::makeTimecode($request->get('timecode')) + 1;
        $timecode->start = Carbon::now();
        $timecode->save();
        $t = Timecode::addToCache($timecode);
        // add it to the cache.
        $request->session()->flash('success', 'The timecode was added.');
        return redirect()->route('timecode');
    }

    public function users()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();
        $request->session()->flash('success', 'The user was added.');
        return redirect()->route('users');
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->get('id'));
        $user->delete();
        $request->session()->flash('success', 'The user was deleted.');
        return redirect()->route('users');
    }
}
