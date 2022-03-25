<?php

namespace Tests\Unit;

use Bedard\Backend\Field;
use PHPUnit\Framework\TestCase;
use Bedard\Backend\Fields\NumberField;

class FieldTest extends TestCase
{
    public function test_creating_a_field_from_alias()
    {
        $field = Field::number('id');
        
        $this->assertEquals(NumberField::class, $field::class);
    }

    public function test_creating_a_field_from_make_helper()
    {
        $field = NumberField::make('id');

        $this->assertEquals(NumberField::class, $field::class);
    }

    public function test_setting_field_properties()
    {
        $field = Field::make('email')
            ->label('Email address');
        
        $this->assertEquals('email', $field->column);
        $this->assertEquals('Email address', $field->label);
    }
}
