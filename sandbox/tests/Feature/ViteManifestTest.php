<?php

namespace Tests\Unit;

use Bedard\Backend\Classes\ViteManifest;
use Tests\TestCase;

class ViteManifestTest extends TestCase
{
    public function test_parsing_manifest_file(): void
    {
        $manifest = new ViteManifest(__DIR__ . '/stubs/manifest.stub.json');
        $scripts = $manifest->scripts();
        $styles = $manifest->styles();

        $this->assertEquals([
            'assets/layout-cc8e5c74.js',
            'assets/main-5e5fd67a.js',
        ], $scripts);

        $this->assertEquals([
            'assets/main-3872e0b7.css',
        ], $styles);

        $this->assertEquals('assets/main-5e5fd67a.js', $manifest->script('client/main.ts'));
    }
}
