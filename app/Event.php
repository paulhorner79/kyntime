<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $appends = ['calculated', 'readable'];

    public function __toString()
    {
        return $this->name;
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getCalculatedAttribute()
    {
        return Timecode::makeTime($this->timecode);
    }

    public function getReadableAttribute()
    {
        $time = $this->calculated;
        return $time['hour'].':'.$time['minute'].':'.$time['second'];
    }
}
