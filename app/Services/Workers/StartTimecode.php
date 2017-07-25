<?php

namespace App\Services\Workers;

use App\Services\Job;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Timecode;

class StartTimecode implements Job
{
    public function run()
    {
        if ($timecode = Timecode::first()) {
            // if it's more than 3 hours old, clear it
            if ($timecode->current['hour'] < 3) {
                return 'The timecode is already running';
            } else {
                foreach (Timecode::all() as $t) {
                    $t->delete();
                }
                Cache::forget('kyntime-timecode');
            }
        }

        $timecode = new Timecode;
        $timecode->timecode = 1;
        $timecode->start = Carbon::now();
        $timecode->save();
        $t = Timecode::addToCache($timecode);
        return 'The timecode has been started';
    }
}
