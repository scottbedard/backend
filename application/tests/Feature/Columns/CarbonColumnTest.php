<?php

namespace Tests\Feature\Columns;

use Carbon\Carbon;
use Illuminate\database\Eloquent\Model;
use Bedard\Backend\Columns\CarbonColumn;
use Tests\TestCase;

class CarbonColumnTest extends TestCase
{
    public function test_default_carbon_formatting()
    {
        $model = new class extends Model {
            public $attributes = ['created_at' => '2022-01-01 01:23:45'];
        };

        $column = new CarbonColumn('created_at');

        $this->assertEquals('Jan 1st, 2022', $column->render($model));
    }

    public function test_custom_carbon_formatting()
    {
        $model = new class extends Model {
            public $attributes = ['created_at' => '2022-01-01 01:23:45'];
        };

        $column = new CarbonColumn('created_at');

        $this->assertEquals('January 2022', $column->format('F Y')->render($model));
    }

    public function test_custom_carbon_parsing()
    {
        $model = new class extends Model {
            public $attributes = ['timestamp' => '1653713409'];
        };

        $column = new CarbonColumn('timestamp');

        $this->assertEquals('May 28th, 2022', $column->parse('U')->render($model));
    }

    public function test_rendering_diff_for_humans()
    {
        $model = new class extends Model { };
        $model->created_at = Carbon::yesterday();

        $column = new CarbonColumn('created_at');

        $this->assertEquals('1 day ago', $column->diffForHumans()->render($model));
    }
}
