<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\SceneAdminPage;

class SceneTest extends DuskTestCase
{
    public function testListScenes()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SceneAdminPage)
                  ->assertSeeIn('.table', 'Boudicca')
                  ->assertSeeIn('.table', 'The Romans')
                  ->assertSeeIn('.table', 'Georgian Spring');
        });
    }

    public function testAddScene()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SceneAdminPage)
                  ->assertDontSeeIn('.table', 'Test Scene')
                  ->press('@add_link');
            $admin->whenAvailable('#addModal', function ($modal) {
                $modal->type('@add_name', 'Test Scene')
                      ->type('@add_h', '2')
                      ->type('@add_m', '30')
                      ->type('@add_s', '0')
                      ->press('@add_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The scene was created.')
                  ->assertSeeIn('.table', 'Test Scene');
        });
    }

    public function testEditScene()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SceneAdminPage)
                  ->assertSeeIn('.table', 'Test Scene')
                  ->assertDontSeeIn('.table', 'Test Scene (Edited)')
                  ->press('@edit_link');
            $admin->whenAvailable('#editModal', function ($modal) {
                $modal->type('@edit_name', 'Test Scene (Edited)')
                      ->press('@edit_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The scene was updated.')
                  ->assertSeeIn('.table', 'Test Scene (Edited)');
        });
    }

    public function testDeleteScene()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SceneAdminPage)
                  ->assertSeeIn('.table', 'Test Scene (Edited)')
                  ->press('@del_link');
            $admin->whenAvailable('#deleteModal', function ($modal) {
                $modal->press('@conf_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The scene was deleted.')
                  ->assertDontSeeIn('.table', 'Test Scene');
        });
    }
}
