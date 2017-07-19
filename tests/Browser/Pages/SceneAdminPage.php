<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class SceneAdminPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/scenes';
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
            '@add_link'  => 'button.btn-add',
            '@add_name'  => 'name',
            '@add_h'     => 'start[hour]',
            '@add_m'     => 'start[minute]',
            '@add_s'     => 'start[second]',
            '@add_btn'   => 'button.btn-primary',
            '@edit_link' => 'table.table > tbody > tr:last-child > td:nth-child(4) > button.edit-scene',
            '@edit_name' => 'name',
            '@edit_btn'  => 'button.btn-primary',
            '@del_link'  => 'table.table > tbody > tr:last-child > td:nth-child(4) > button.delete-scene',
            '@conf_btn'  => 'button.btn-danger',
        ];
    }
}
