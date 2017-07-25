<?php

namespace App\Services;

interface Job
{
    /**
     * Run the Job
     *
     * @return void
     */
    public function run();
}
