<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class SectionAdminPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/sections';
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
            '@add_btn'   => 'button.btn-primary',
            '@edit_link' => 'table.table > tbody > tr:last-child > td:nth-child(3) > button.edit-section',
            '@edit_name' => 'name',
            '@edit_btn'  => 'button.btn-primary',
            '@del_link'  => 'table.table > tbody > tr:last-child > td:nth-child(3) > button.delete-section',
            '@conf_btn'  => 'button.btn-danger',
        ];
    }
}
