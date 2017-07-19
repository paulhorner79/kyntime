<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class UserAdminPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/users';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@add_link' => 'button.btn-add',
            '@name'     => 'name',
            '@email'    => 'email',
            '@password' => 'password',
            '@add_btn'  => 'button.btn-primary',
            '@del_link' => 'table.table > tbody > tr:last-child > td:nth-child(3) > button',
            '@conf_btn' => 'button.btn-danger',
        ];
    }
}
