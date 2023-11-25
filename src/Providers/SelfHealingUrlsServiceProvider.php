<?php

namespace Lukeraymonddowning\SelfHealingUrls\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;
use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\KebabSlugSanitizer;

class SelfHealingUrlsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(SlugSanitizer::class, fn () => new KebabSlugSanitizer());
    }

    public function provides(): array
    {
        return [
            SlugSanitizer::class,
        ];
    }
}