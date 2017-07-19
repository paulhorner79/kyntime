<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionSeeder extends Seeder
{
    public $sections = [
        ['id' => 1, 'name' => 'Tech 1'],
        ['id' => 2, 'name' => 'Tech 2'],
        ['id' => 3, 'name' => 'Tech 3'],
        ['id' => 4, 'name' => 'Stage Right (Bagpipes)'],
        ['id' => 5, 'name' => 'Stage Left (Drums)']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sections as $section) {
            $s = new Section;
            $s->id = $section['id'];
            $s->name = $section['name'];
            $s->active = true;
            $s->save();
        }
    }
}
