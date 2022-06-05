<?php

namespace Tests\Feature;

use App\Models\User;
use Backend;
use Bedard\Backend\Console\DeauthorizeCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeauthorizeCommandTest extends TestCase
{
    use RefreshDatabase;
}
