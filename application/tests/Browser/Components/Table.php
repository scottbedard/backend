<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class Table extends BaseComponent
{
    public function assertHeaderNotSelected(Browser $browser)
    {
        $browser->assertNotPresent('[data-table-header] [data-checked]');
    }

    public function assertHeaderSelected(Browser $browser)
    {
        $browser->assertPresent('[data-table-header] [data-checked]');
    }

    public function assertAllRowsSelected(Browser $browser)
    {
        $browser
            ->assertNotPresent('[data-table-body] [data-not-checked]')
            ->assertPresent('[data-table-body] [data-checked]');
    }

    public function assertNoRowsSelected(Browser $browser)
    {
        $browser
            ->assertPresent('[data-table-body] [data-not-checked]')
            ->assertNotPresent('[data-table-body] [data-checked]');
    }

    public function clickRow(Browser $browser, int $index)
    {
        $browser->click("[data-table-row=\"{$index}\"]");
    }
    
    public function elements()
    {
        return [];
    }

    public function selector()
    {
        return '[data-table]';
    }
    
    public function toggleHeaderCheckbox(Browser $browser)
    {
       $browser->click('[data-table-header] [data-checkbox]');
    }

    public function toggleRowCheckbox(Browser $browser, int $index)
    {
        $browser->click("[data-table-row=\"{$index}\"] [data-checkbox]");
    }
}
