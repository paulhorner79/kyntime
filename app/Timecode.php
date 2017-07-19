<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Timecode extends Model
{
    public $timestamps = false;
    protected $dates = ['start'];
    protected $appends = ['current', 'readable', 'now'];

    public function __toString()
    {
        return $this->readable;
    }

    public function getReadableAttribute()
    {
        $time = $this->current;
        return $time['hour'].':'.$time['minute'].':'.$time['second'];
    }

    public function getCurrentAttribute()
    {
        // seconds between now and when it was created
        $diff    = $this->start->diffInSeconds(Carbon::now());
        $current = $this->timecode + $diff;
        return $this->makeTime($current);
    }

    public function getNowAttribute()
    {
        // seconds between now and when it was created
        return Carbon::now()->toTimeString();
    }

    public static function makeTime($int)
    {
        $timecode = Carbon::today()->addSeconds($int);
        return [
            'hour' => $timecode->hour,
            'minute' => $timecode->minute,
            'second' => $timecode->second
        ];
    }

    public static function makeTimecode($array)
    {
        $time = 0;
        $hour = $array['hour'];
        $minute = $array['minute'];
        $second = $array['second'];
        $neg = false;
        if ($hour < 0) {
            $neg = true;
            $hour = $hour * -1;
        }
        if ($minute < 0) {
            $neg = true;
            $minute = $minute * -1;
        }
        if ($second < 0) {
            $neg = true;
            $second = $second * -1;
        }

        $time = $time + ($hour * 60 * 60) + ($minute * 60) + $second;
        if ($neg === true) {
            return $time * -1;
        }
        return $time;
    }

    public static function makeCurrent(Carbon $start, $timecode)
    {
        $diff    = $start->diffInSeconds(Carbon::now());
        $current = $timecode + $diff;
        $tc = Carbon::today()->addSeconds($current);
        return [
            'hour'   => $tc->hour,
            'minute' => $tc->minute,
            'second' => $tc->second
        ];
    }

    public static function addToCache($timecode)
    {
        $t = [
            'id'       => $timecode->id,
            'timecode' => $timecode->timecode,
            'start'    => $timecode->start
        ];
        if ($last = Scene::whereNotNull('end')->orderBy('end', 'desc')->first()) {
            $end = (int) $last->getOriginal('end');
            $t['end'] = $end + 300;
        }
        Cache::put('kyntime-timecode', $t);
        return $t;
    }

    public static function cacheVersion()
    {
        $t = Cache::get('kyntime-timecode', function () {
            if ($timecode = Timecode::orderBy('timecode')->first()) {
                return Timecode::addToCache($timecode);
            }
            return null;
        });
        return $t;
    }

    public static function apiVersion($t)
    {
        if ($t) {
            $timecode = Timecode::makeCurrent($t['start'], $t['timecode']);
            return [
                'id' => $t['id'],
                'timecode' => $timecode,
                'end' => $t['end']
            ];
        }
        return [];
    }
}
