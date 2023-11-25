<?php

namespace Lukeraymonddowning\SelfHealingUrls\Contracts;

interface SlugSanitizer
{
    public function sanitize(string $slug): string;
}
