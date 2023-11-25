<?php

namespace Tests;

use Lukeraymonddowning\SelfHealingUrls\Providers\SelfHealingUrlsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/fixtures/migrations');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
    }

    protected function getPackageProviders($app): array
    {
        return [
            SelfHealingUrlsServiceProvider::class,
        ];
    }
}
