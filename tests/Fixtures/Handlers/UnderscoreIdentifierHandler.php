<?php

namespace Tests\Fixtures\Handlers;

use Illuminate\Support\Str;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;

class UnderscoreIdentifierHandler implements IdentifierHandler
{
    public function joinToSlug(string $slug, string|int $identifier): string
    {
        return "{$identifier}_{$slug}";
    }

    public function separateFromSlug(string $value): string
    {
        return Str::before($value, '_');
    }
}