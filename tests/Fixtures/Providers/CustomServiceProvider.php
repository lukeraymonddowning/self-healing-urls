<?php

namespace Tests\Fixtures\Providers;

use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;
use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\BaseSlugSanitizer;
use Tests\Fixtures\Handlers\UnderscoreIdentifierHandler;

class CustomServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SlugSanitizer::class, fn () => new BaseSlugSanitizer(separator: '_'));
        $this->app->singleton(IdentifierHandler::class, UnderscoreIdentifierHandler::class);
    }
}