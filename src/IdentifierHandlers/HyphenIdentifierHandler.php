<?php

namespace Lukeraymonddowning\SelfHealingUrls\IdentifierHandlers;

use Illuminate\Support\Str;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;

class HyphenIdentifierHandler implements IdentifierHandler
{
    public function joinToSlug(string $slug, string|int $identifier): string
    {
        return "{$slug}-{$identifier}";
    }

    public function separateFromSlug(string $value): string
    {
        return Str::afterLast($value, '-');
    }
}
