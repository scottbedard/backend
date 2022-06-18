<?php

namespace Tests\Browser\Components;

use Bedard\Backend\Classes\SortOrder;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class Table extends BaseComponent
{
    public function assertAllRowsSelected(Browser $browser)
    {
        $browser
            ->assertNotPresent('[data-table-body] [data-not-checked]')
            ->assertPresent('[data-table-body] [data-checked]');
    }

    public function assertHeaderNotSelected(Browser $browser)
    {
        $browser->assertNotPresent('[data-table-header] [data-checked]');
    }

    public function assertHeaderSelected(Browser $browser)
    {
        $browser->assertPresent('[data-table-header] [data-checked]');
    }

    public function assertNoRowsSelected(Browser $browser)
    {
        $browser
            ->assertPresent('[data-table-body] [data-not-checked]')
            ->assertNotPresent('[data-table-body] [data-checked]');
    }
    
    public function assertOrder(Browser $browser, string $column, string $direction)
    {
        $order = SortOrder::from("{$column},{$direction}");

        $browser->assertPresent("[data-table-header=\"{$column}\"][data-table-sorted=\"{$order->direction}\"]");
    }

    public function assertSeeInCell(Browser $browser, string $column, int $row, $text)
    {
        $browser->assertSeeIn("[data-table-row=\"{$row}\"] [data-table-column=\"{$column}\"]", $text);
    }

    public function clickHeader(Browser $browser, string $id)
    {
        $browser->click("[data-table-header=\"{$id}\"]");
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
