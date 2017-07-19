<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Scene extends Model
{

    //protected $appends = ['start', 'end'];

    public function __toString()
    {
        return $this->name;
    }

    public function makeTime($value)
    {
        if ($value) {
            $time = Timecode::makeTime($value);
            $readable = $time['hour'].':'.$time['minute'].':'.$time['second'];
            return [
                'time'     => $time,
                'readable' => $readable
            ];
        }
        return null;
    }

    public function getStartAttribute($value)
    {
        return $this->makeTime($value);
    }

    public function getEndAttribute($value)
    {
        return $this->makeTime($value);
    }
}
