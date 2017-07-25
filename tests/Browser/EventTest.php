<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\EventAdminPage;

class EventTest extends DuskTestCase
{
    public function testListEvents()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new EventAdminPage(3))
                  ->assertSeeIn('.table', 'Close back track for finale')
                  ->assertSeeIn('.table', 'Ignite Papuan Torches')
                  ->assertSeeIn('.table', 'Ready bucket of water');
        });
    }

    public function testAddEvent()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new EventAdminPage(3))
                  ->assertDontSeeIn('.table', 'ZTest Event')
                  ->press('@add_link');
            $admin->whenAvailable('#addModal', function ($modal) {
                $modal->type('@add_name', 'ZTest Event')
                      ->type('@add_h', '2')
                      ->type('@add_m', '29')
                      ->type('@add_s', '59')
                      ->pause(50)
                      ->press('@add_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The event was created.')
                  ->assertSeeIn('.table', 'ZTest Event');
        });
    }

    public function testEditEvent()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new EventAdminPage(3))
                  ->assertSeeIn('.table', 'ZTest Event')
                  ->assertDontSeeIn('.table', 'ZTest Event (Edited)')
                  ->press('@edit_link');
            $admin->whenAvailable('#editModal', function ($modal) {
                $modal->type('name', 'ZTest Event (Edited)')
                      ->pause(50)
                      ->press('@edit_btn');
            });
            $admin->waitFor('.alerts')
                  ->pause(300)
                  ->assertSeeIn('.alerts', 'The event was updated.')
                  ->assertSeeIn('.table', 'ZTest Event (Edited)');
        });
    }

    public function testDeleteEvent()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new EventAdminPage(3))
                  ->assertSeeIn('.table', 'ZTest Event (Edited)')
                  ->press('@del_link');
            $admin->whenAvailable('#deleteModal', function ($modal) {
                $modal->press('@conf_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The event was deleted.')
                  ->assertDontSeeIn('.table', 'ZTest Event');
        });
    }
}
