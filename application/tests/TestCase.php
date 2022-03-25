<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Files to clean up before and after each test.
     *
     * @var $array
     */
    public $testFiles = [];

    /**
     * Delete test files.
     */
    public function deleteTestFiles()
    {
        foreach ($this->testFiles as $testFile) {
            File::delete(base_path($testFile));
        }
    }

    /**
     * Clean up the testing environment before the next test.
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->deleteTestFiles();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->deleteTestFiles();
        
        parent::tearDown();
    }
}
