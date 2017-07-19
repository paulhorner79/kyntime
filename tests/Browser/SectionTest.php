<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\SectionAdminPage;

class SectionTest extends DuskTestCase
{
    public function testListSections()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SectionAdminPage)
                  ->assertSeeIn('.table', 'Tech 1')
                  ->assertSeeIn('.table', 'Stage Left');
        });
    }

    public function testAddSection()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SectionAdminPage)
                  ->assertDontSeeIn('.table', 'Test Section')
                  ->press('@add_link');
            $admin->whenAvailable('#addModal', function ($modal) {
                $modal->type('@add_name', 'Test Section')
                      ->press('@add_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The section was created.')
                  ->assertSeeIn('.table', 'Test Section');
        });
    }

    public function testEditSection()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SectionAdminPage)
                  ->assertSeeIn('.table', 'Test Section')
                  ->assertDontSeeIn('.table', 'Test Section (Edited)')
                  ->press('@edit_link')
                  ->whenAvailable('#editModal', function ($modal) {
                        $modal->type('@edit_name', 'Test Section (Edited)')
                              ->press('@edit_btn');
                  })
                  ->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The section was updated.')
                  ->assertSeeIn('.table', 'Test Section (Edited)');
        });
    }

    public function testDeleteSection()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new SectionAdminPage)
                  ->assertSeeIn('.table', 'Test Section (Edited)')
                  ->press('@del_link');
            $admin->whenAvailable('#deleteModal', function ($modal) {
                $modal->press('@conf_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The section was deleted.')
                  ->assertDontSeeIn('.table', 'Test Section');
        });
    }
}
