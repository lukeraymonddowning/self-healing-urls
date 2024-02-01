<?php

namespace Lukeraymonddowning\SelfHealingUrls\Providers;

use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Contracts\Rerouter;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;
use Lukeraymonddowning\SelfHealingUrls\IdentifierHandlers\HyphenIdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Rerouters\NamedRouteRerouter;
use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\BaseSlugSanitizer;

class SelfHealingUrlsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SlugSanitizer::class, fn () => new BaseSlugSanitizer());
        $this->app->singleton(Rerouter::class, NamedRouteRerouter::class);
        $this->app->singleton(IdentifierHandler::class, HyphenIdentifierHandler::class);
    }
}
