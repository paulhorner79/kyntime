<?php

namespace Tests\Browser;

use App\User;
use App\Timecode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\Browser\Pages\SetTimecodePage;

class AdminTest extends DuskTestCase
{
    public function testAnonCannotViewAdminPages()
    {
        $this->browse(function (Browser $anon) {
            $anon->visit('/users')->assertSee('Login')->assertSee('Password');
            $anon->visit('/sections')->assertSee('Login')->assertSee('Password');
            $anon->visit('/sections/1/events')->assertSee('Login')->assertSee('Password');
            $anon->visit('/scenes')->assertSee('Login')->assertSee('Password');
        });
    }

    public function testStartTimecode()
    {
        Cache::forget('kyntime-timecode');
        foreach (Timecode::all() as $tc) {
            $tc->delete();
        }
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->press('@start')
                  ->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The timecode was added.');
        });
    }

    public function testStopTimecode()
    {
        Cache::forget('kyntime-timecode');
        foreach (Timecode::all() as $tc) {
            $tc->delete();
        }
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SetTimecodePage)
                  ->press('@start')
                  ->waitFor('.alerts')
                  ->press('@stop')
                  ->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The timecode was cleared.');
        });
    }
}
