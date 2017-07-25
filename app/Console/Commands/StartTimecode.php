<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Timecode;

class StartTimecode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timecode:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the timecode.  Starts it running at 00:00:00.';

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
            // if it's more than 3 hours old, clear it
            if ($timecode->current['hour'] < 3) {
                $this->info('The timecode is already running');
                return;
            } else {
                foreach (Timecode::all() as $t) {
                    $t->delete();
                }
                Cache::forget('kyntime-timecode');
                $this->info('Cleared expired timecodes');
            }
        }

        $timecode = new Timecode;
        $timecode->timecode = 1;
        $timecode->start = Carbon::now();
        $timecode->save();
        $this->info('The timecode has been added to the database');
        $t = Timecode::addToCache($timecode);
        $this->info('The timecode has been added to the cache');
    }
}
