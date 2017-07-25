<?php

namespace App\Services\Workers;

use App\Services\Job;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Timecode;

class StopTimecode implements Job
{
    public function run()
    {
        if ($timecode = Timecode::first()) {
            // if it's less than 03:00:00, do nothing
            if ((int) $timecode->current['hour'] < 3) {

                return 'The timecode is less than 03:00:00';
            } else {
                foreach (Timecode::all() as $t) {
                    $t->delete();
                }
                Cache::forget('kyntime-timecode');
                return 'Cleared expired timecodes';
            }
        }
        return 'No timecode was running';
    }
}
