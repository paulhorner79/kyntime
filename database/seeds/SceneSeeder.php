<?php

use Illuminate\Database\Seeder;
use App\Scene;

class SceneSeeder extends Seeder
{
    public $scenes = [
        ['id' => 2, 'name' => 'Dear Dear Land',             'start' => '01:00:00'],
        ['id' => 3, 'name' => 'The Story of Us',            'start' => '01:03:07'],
        ['id' => 4, 'name' => 'Legend of the Wear',         'start' => '01:05:13'],
        ['id' => 5, 'name' => 'Gatehouse of Time',          'start' => '01:06:38'],
        ['id' => 6, 'name' => 'Joseph and the Grail',       'start' => '01:08:24'],
        ['id' => 7, 'name' => 'Boudicca',                   'start' => '01:09:54'],
        ['id' => 8, 'name' => 'The Romans',                 'start' => '01:12:24'],
        ['id' => 9, 'name' => 'Saint Cuthbert',             'start' => '01:15:57'],
        ['id' => 10, 'name' => 'Viking Attack',             'start' => '01:17:45'],
        ['id' => 11, 'name' => 'Stamford Bridge',           'start' => '01:20:18'],
        ['id' => 12, 'name' => 'Norman Conquest',           'start' => '01:24:14'],
        ['id' => 13, 'name' => 'Coronation',                'start' => '01:26:30'],
        ['id' => 14, 'name' => 'Medieval Festival',         'start' => '01:30:44'],
        ['id' => 15, 'name' => 'The Scots are Coming!',     'start' => '01:34:44'],
        ['id' => 16, 'name' => 'Knights of the Round',      'start' => '01:38:40'],
        ['id' => 17, 'name' => 'Field of the Cloth of Gold','start' => '01:40:40'],
        ['id' => 18, 'name' => 'Shakespeare',               'start' => '01:43:48'],
        ['id' => 19, 'name' => 'Civil War',                 'start' => '01:49:18'],
        ['id' => 20, 'name' => 'Georgian Harvest',          'start' => '01:51:53'],
        ['id' => 21, 'name' => 'Georgian Spring',           'start' => '01:55:23'],
        ['id' => 22, 'name' => 'Locomotion',                'start' => '01:57:42'],
        ['id' => 23, 'name' => 'The Mines',                 'start' => '01:59:38'],
        ['id' => 24, 'name' => 'Durham Cathedral',          'start' => '02:02:26'],
        ['id' => 25, 'name' => 'Diamond Jubilee',           'start' => '02:06:41'],
        ['id' => 26, 'name' => 'The Christmas Truce',       'start' => '02:11:32'],
        ['id' => 27, 'name' => 'Miners\' Gala',             'start' => '02:15:07'],
        ['id' => 28, 'name' => 'Their Finest Hour',         'start' => '02:18:51'],
        ['id' => 29, 'name' => 'Arthur\'s Epilogue',        'start' => '02:22:22'],
        ['id' => 30, 'name' => 'Finale',                    'start' => '02:23:52'],
        ['id' => 31, 'name' => 'Reprise',                   'start' => '02:28:19', 'end' => '02:30:00']
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
        foreach ($this->scenes as $scene) {
            $s = new Scene;
            $s->id = $scene['id'];
            $s->name = $scene['name'];
            $s->start = $this->makeTime($scene['start']);
            if (isset($scene['end'])) {
                $s->end = $this->makeTime($scene['end']);
            }
            $s->save();
        }
    }
}
