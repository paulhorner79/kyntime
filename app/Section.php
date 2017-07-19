<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function __toString()
    {
        return $this->name;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
