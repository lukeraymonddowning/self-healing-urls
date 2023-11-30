<?php

namespace Lukeraymonddowning\SelfHealingUrls\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Contracts\Rerouter;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;
use Lukeraymonddowning\SelfHealingUrls\IdentifierHandlers\HyphenIdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Rerouters\NamedRouteRerouter;
use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\StringHelperSlugSanitizer;

class SelfHealingUrlsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->singleton(SlugSanitizer::class, fn () => new StringHelperSlugSanitizer());
        $this->app->singleton(Rerouter::class, NamedRouteRerouter::class);
        $this->app->singleton(IdentifierHandler::class, HyphenIdentifierHandler::class);
    }

    public function provides(): array
    {
        return [
            SlugSanitizer::class,
            Rerouter::class,
            IdentifierHandler::class,
        ];
    }
}
