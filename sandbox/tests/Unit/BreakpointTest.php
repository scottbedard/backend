<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\Breakpoint;
use PHPUnit\Framework\TestCase;

class BreakpointTest extends TestCase
{
    public function test_standard_breakpoints(): void
    {
        $bp = Breakpoint::create(6);

        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 12,
            'lg' => 6,
            'xl' => 6,
            '2xl' => 6,
        ], $bp);
    }

    public function test_custom_breakpoints()
    {
        $bp = Breakpoint::create([
            'md' => 6,
            'xl' => 4,
        ]);

        $this->assertEquals([
            'xs' => 12,
            'sm' => 12,
            'md' => 6,
            'lg' => 6,
            'xl' => 4,
            '2xl' => 4,
        ], $bp);
    }
}
