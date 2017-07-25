<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Timecode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTest extends TestCase
{

    private function clearTimecode()
    {
        Cache::forget('kyntime-timecode');
        foreach (Timecode::all() as $tc) {
            $tc->delete();
        }
    }

    private function setTimecode($i)
    {
        $timecode = new Timecode;
        $timecode->timecode = $i;
        $timecode->start = Carbon::now();
        $timecode->save();

        return $timecode;
    }

    public function testGetEmptyTimecode()
    {
        $this->clearTimecode();
        $response = $this->get('/api/timecode');
        $response->assertStatus(200)
                 ->assertExactJson([]);
    }

    public function testGetTimecode()
    {
        $this->clearTimecode();

        $timecode = $this->setTimecode(1);
        $response = $this->get('/api/timecode');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'timecode',
                     'end'
                 ]);
    }

    public function testGetEvents()
    {
        $response = $this->get('/api/events');
        $response->assertStatus(200);
    }

    public function testGetScenes()
    {
        $response = $this->get('/api/scenes');
        $response->assertStatus(200);
    }

    public function testGetSections()
    {
        $response = $this->get('/api/sections');
        $response->assertStatus(200);
    }

    public function testStartTimecode()
    {
        $this->clearTimecode();
        $response = $this->post('/api/worker/start-timecode');
        $response->assertStatus(200)
                 ->assertExactJson(['info' => 'The timecode has been started']);
    }

    public function testStopTimecode()
    {

        $response = $this->post('/api/worker/stop-timecode');
        $response->assertStatus(200)
                 ->assertExactJson(['info' => 'The timecode is less than 03:00:00']);
        $this->clearTimecode();
        $timecode = $this->setTimecode((60 * 60 * 5) + 15);
        echo json_encode($timecode);
        $response = $this->post('/api/worker/stop-timecode');
        $response->assertStatus(200)
                 ->assertExactJson(['info' => 'Cleared expired timecodes']);
    }
}
