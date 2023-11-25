<?php

namespace Lukeraymonddowning\SelfHealingUrls\Contracts;

interface IdentifierHandler
{
    public function joinToSlug(string $slug, string|int $identifier): string;

    public function separateFromSlug(string $value): string;
}
