<?php

namespace App\Services;

class Worker
{
    /**
     * Get the Job object
     *
     * @param string $name
     * @return Job
     */
    public static function job($name)
    {
        $namespace = sprintf('App\Services\Workers\%s', studly_case($name));

        if (class_exists($namespace)) {
            return new $namespace;
        }
        return false;
    }
}
