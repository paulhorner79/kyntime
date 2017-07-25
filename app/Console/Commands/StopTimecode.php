<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Timecode;

class StopTimecode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timecode:stop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stops any timecode older than 03:00:00';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($timecode = Timecode::first()) {
            // if it's less than 03:00:00, do nothing
            if ($timecode->current['hour'] < 3) {
                $this->info('The timecode is less than 03:00:00');
            } else {
                foreach (Timecode::all() as $t) {
                    $t->delete();
                }
                Cache::forget('kyntime-timecode');
                $this->info('Cleared expired timecodes');
            }
        } else {
            $this->info('No timecode was running');
        }
    }
}
