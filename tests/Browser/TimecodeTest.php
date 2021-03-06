<?php

namespace Tests\Browser;

use App\User;
use App\Timecode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\SetTimecodePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;

class TimecodeTest extends DuskTestCase
{
    private function clearTimecode()
    {
        Cache::forget('kyntime-timecode');
        foreach (Timecode::all() as $tc) {
            $tc->delete();
        }
    }

    private function setTimecode($h, $m, $s)
    {
        $this->clearTimecode();
        $this->browse(function (Browser $admin) use ($h, $m, $s) {
            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->type('@hour', $h)
                  ->type('@minute', $m)
                  ->type('@second', $s)
                  ->press('@start');
        });
    }

    public function testTimecodePage()
    {
        $this->clearTimecode();
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                    ->waitFor('@timecode')
                    ->assertSeeIn('@timecode', '00:00:00');
        });
    }

    public function testTimecodeStartsMoving()
    {
        $this->clearTimecode();
        $this->browse(function (Browser $anon, Browser $admin) {
            $anon->visit(new HomePage)
                 ->waitFor('@timecode')
                 ->assertSeeIn('@timecode', '00:00:00');

            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->type('@minute', '30')
                  ->press('@start');

            $anon->visit(new HomePage)
                 ->waitFor('@timecode')
                 ->assertDontSeeIn('@timecode', '00:00:00');
        });
    }

    public function testTimecodeInSyncBetweenBrowsers()
    {
        $this->browse(function (Browser $first, Browser $second) {
            $first->visit(new HomePage)
                   ->waitFor('@timecode');

            $second->visit(new HomePage)
                   ->waitFor('@timecode');

            $tc = explode(":", $first->text('@active'));
            $tc2 = explode(":", $second->text('@active'));

            $this->assertEquals($tc[0], $tc2[0]);
            $this->assertEquals($tc[1], $tc2[1]);
            $this->assertGreaterThanOrEqual((int) $tc[2], (int) $tc2[2] + 2);
            $this->assertLessThanOrEqual((int) $tc[2], (int) $tc2[2] - 2);
        });
    }

    public function testTimecodeStopsOnEnd()
    {
        $this->browse(function (Browser $anon, Browser $admin) {
            $anon->visit(new HomePage)
                 ->waitFor('@active');

            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->press('@stop');

            $anon->visit(new HomePage)
                 ->waitFor('@inactive');
        });
    }

    public function testTimecodeStopsAutomatically()
    {
        $this->setTimecode(2, 34, 55);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('@active')
                 ->waitFor('@inactive', 5);
        });
    }

    public function testSceneDisplay()
    {
        $this->setTimecode(1, 9, 0);
        $this->browse(function (Browser $anon) {

            $anon->visit(new HomePage)
                 ->waitFor('@active')
                 ->assertSeeIn('@currentScene', 'Joseph and the Grail')
                 ->assertSeeIn('@nextScene', 'Boudicca');
        });
    }

    public function testSceneChange()
    {
        $this->setTimecode(1, 9, 48);
        $this->browse(function (Browser $anon) {

            $anon->visit(new HomePage)
                 ->waitFor('@active')
                 ->assertSeeIn('@currentScene', 'Joseph and the Grail')
                 ->assertSeeIn('@nextScene', 'Boudicca')
                 ->pause(6500)
                 ->assertSeeIn('@currentScene', 'Boudicca')
                 ->assertSeeIn('@nextScene', 'The Romans');
        });
    }

    public function testSectionChange()
    {
        $this->setTimecode(0, 0, 0);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('.sections')
                 ->select('section', 2)
                 ->assertSeeIn('@firstEvent', 'Ready bucket of water')
                 ->select('section', 4)
                 ->assertSeeIn('@firstEvent', 'Prepare Vestal Torches');
        });
    }

    public function testSectionIsRemembered()
    {
        $this->setTimecode(0, 0, 0);
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                    ->waitFor('@events')
                    ->assertSeeIn('@firstEvent', 'Prepare Vestal Torches');
        });
    }

    public function testSceneList()
    {
        $this->setTimecode(1, 10, 00);
        $this->browse(function (Browser $anon) {

            $anon->visit(new HomePage)
                 ->waitFor('@section')
                 ->select('section', 999999)
                 ->waitFor('@scenes')
                 ->pause(1000)
                 ->assertSeeIn('@scenes', 'The Romans')
                 ->assertSeeIn('@thisScene', 'Boudicca');
        });
    }

    public function testFutureToPendingEvents()
    {
        $this->setTimecode(2, 23, 04);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('@section')
                 ->select('section', 0)
                 ->select('section', 3)
                 ->waitFor('@events')
                 ->assertSeeIn('@future', 'Close back track for finale')
                 ->pause(5500)
                 ->assertSeeIn('@pending', 'Close back track for finale');
        });
    }

    public function testPendingToCurrentEvents()
    {
        $this->setTimecode(2, 26, 03);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('@section')
                 ->select('section', 0)
                 ->select('section', 3)
                 ->waitFor('@events')
                 ->assertSeeIn('@pending', 'Close back track for finale')
                 ->pause(6000)
                 ->assertSeeIn('@current', 'Close back track for finale');
        });
    }

    public function testCurrentToPastEvents()
    {
        $this->setTimecode(2, 26, 34);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('@section')
                 ->select('section', 0)
                 ->select('section', 3)
                 ->waitFor('@events')
                 ->assertSeeIn('@current', 'Close back track for finale')
                 ->pause(6000)
                 ->assertSeeIn('@past', 'Close back track for finale');
        });
    }

    public function testPreShowEvent()
    {
        $this->setTimecode(0, 59, 54);
        $this->browse(function (Browser $anon) {
            $anon->visit(new HomePage)
                 ->waitFor('@section')
                 ->select('section', 0)
                 ->select('section', 5)
                 ->waitFor('@events')
                 ->assertSeeIn('@pre', 'Prepare Bagpipes')
                 ->assertDontSee('.events.started')
                 ->waitFor('.events.started', 6)
                 ->assertSeeIn('.events.started', 'Prepare Bagpipes');
        });
    }

    public function testStopTimecode()
    {
        $this->clearTimecode();
        $this->browse(function (Browser $anon, Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->type('@minute', '30')
                  ->press('@start');

            $anon->visit(new HomePage)
                 ->waitFor('@timecode')
                 ->assertDontSeeIn('@timecode', '00:00:00');

            $admin->visit(new SetTimecodePage)
                  ->press('@stop');

            $anon->pause(16000)
                 ->assertSeeIn('@timecode', '00:00:00');
        });
    }

    public function testRestartTimecode()
    {
        $this->clearTimecode();
        $this->browse(function (Browser $anon, Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->type('@hour', '1')
                  ->press('@start');

            $anon->visit(new HomePage)
                 ->waitFor('@timecode')
                 ->assertSeeIn('@timecode', '01:00:');

            $admin->visit(new SetTimecodePage)
                  ->press('@stop')
                  ->visit(new SetTimecodePage)
                  ->type('@hour', '2')
                  ->press('@start');

            $anon->pause(16000)
                 ->assertSeeIn('@timecode', '02:00:');
        });
    }
}
