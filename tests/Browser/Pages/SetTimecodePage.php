<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class SetTimecodePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/timecode';
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
            '@timecode' => '.timecode',
            '@active'   => '.timecode .active',
            '@inactive' => '.timecode div:not(.active)',
            '@hour'     => 'timecode[hour]',
            '@minute'   => 'timecode[minute]',
            '@second'   => 'timecode[second]',
            '@start'    => '#start',
            '@stop'     => '#stop'
        ];
    }
}
