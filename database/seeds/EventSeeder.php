<?php

use Illuminate\Database\Seeder;
use App\Event;

class EventSeeder extends Seeder
{
    public $events = [
        ['section_id' => 1, 'name' => 'Ready bucket of water', 'timecode' => '01:00:00'],
        ['section_id' => 1, 'name' => 'Close back track for finale', 'timecode' => '02:26:09', 'notes' => 'Start of "Land of Hope and Glory".'],

        ['section_id' => 2, 'name' => 'Ready bucket of water', 'timecode' => '01:00:00'],
        ['section_id' => 2, 'name' => 'Ignite Viking Torches', 'timecode' => '01:21:18', 'notes' => 'Stand on hill and light 5 at a time if possible.  Someone should be nearby with an extinguisher.'],
        ['section_id' => 2, 'name' => 'Ignite boat torches', 'timecode' => '01:42:00'],
        ['section_id' => 2, 'name' => 'Boat departs with Torches', 'timecode' => '01:43:48'],
        ['section_id' => 2, 'name' => 'Close back track for finale', 'timecode' => '02:26:09', 'notes' => 'Start of "Land of Hope and Glory".'],

        ['section_id' => 3, 'name' => 'Ready bucket of water', 'timecode' => '01:00:00'],
        ['section_id' => 3, 'name' => 'Close back track for Miner\'s Gala', 'timecode' => '02:15:07', 'notes' => 'Wait for horses to pass. Watch for watercake.'],
        ['section_id' => 3, 'name' => 'Close back track for finale', 'timecode' => '02:26:09', 'notes' => 'Start of "Land of Hope and Glory".'],

        ['section_id' => 4, 'name' => 'Prepare Drums', 'timecode' => '01:00:00', 'notes' => '30 drums, check lighters are fueled and switched off.'],
        ['section_id' => 4, 'name' => 'Hand out Drums', 'timecode' => '01:32:44', 'notes' => 'This gets hectic.  Could use help from elsewhere if possible.'],
    ];

    public function makeTime($t)
    {
        $a = explode(':', $t);
        $h = (int) $a[0];
        $m = (int) $a[1];
        $s = (int) $a[2];
        return ($h * 60 * 60) + ($m * 60) + $s;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->events as $event) {
            $e = new Event;
            $e->section_id = $event['section_id'];
            $e->name = $event['name'];
            $e->timecode = $this->makeTime($event['timecode']);
            if (isset($event['notes'])) {
                $e->notes = $event['notes'];
            }
            $e->active = true;
            $e->save();
        }
    }
}
