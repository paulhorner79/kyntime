<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
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
            '@timecode'     => '.timecode',
            '@active'       => '.timecode > .active',
            '@inactive'     => '.timecode > div:not(.active)',
            '@currentScene' => '.scene .current',
            '@nextScene'    => '.scene .next',
            '@section'      => '.sections',
            '@scenes'       => 'div.scenes',
            '@thisScene'    => 'div.scenes > table > tbody > tr.current',
            '@events'       => '.events',
            '@firstEvent'   => '.events .event:first-child',
            '@pending'      => '.events .event.pending:first-child',
            '@future'       => '.events .event.future:first-child',
            '@current'      => '.events .event.current:first-child',
            '@past'         => '.events .event.past:last-child',
            '@pre'          => '.events .event.pre:first-child',
        ];
    }
}
