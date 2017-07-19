<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\Browser\Pages\UserAdminPage;

class UserAdminTest extends DuskTestCase
{

    public function testListAdministrator()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new UserAdminPage)
                  ->assertSeeIn('.table', 'admin@kyntime.com');
        });
    }

    public function testAddAdministrator()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new UserAdminPage)
                  ->assertDontSeeIn('.table', 'test@test.com')
                  ->press('@add_link');
            $admin->whenAvailable('#addModal', function ($modal) {
                $modal->type('@name', 'Test User')
                      ->type('@email', 'test@test.com')
                      ->type('@password', 'Pa$$w0rd!')
                      ->press('@add_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The user was added.')
                  ->assertSeeIn('.table', 'test@test.com');
        });
    }

    public function testDeleteAdministrator()
    {
        $this->browse(function (Browser $admin) {
            $admin->loginAs(User::find(1))
                  ->visit(new UserAdminPage)
                  ->assertSeeIn('.table', 'test@test.com')
                  ->press('@del_link');
            $admin->whenAvailable('#deleteModal', function ($modal) {
                $modal->press('@conf_btn');
            });
            $admin->waitFor('.alerts')
                  ->assertSeeIn('.alerts', 'The user was deleted.')
                  ->assertDontSeeIn('.table', 'test@test.com');
        });
    }
}
