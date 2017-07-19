<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EventAdminPage extends Page
{
    protected $section_id;

    public function __construct($section_id)
    {
        $this->section_id = $section_id;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/sections/'.$this->section_id.'/events';
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
            '@add_h'     => 'timecode[hour]',
            '@add_m'     => 'timecode[minute]',
            '@add_s'     => 'timecode[second]',
            '@add_btn'   => 'button.btn-primary',
            '@edit_link' => 'table.table > tbody > tr:last-child > td:nth-child(5) > button.edit-event',
            '@edit_name' => 'name',
            '@edit_btn'  => 'button.btn-primary',
            '@del_link'  => 'table.table > tbody > tr:last-child > td:nth-child(5) > button.delete-event',
            '@conf_btn'  => 'button.btn-danger',
        ];
    }
}
