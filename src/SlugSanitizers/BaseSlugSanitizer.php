<?php

namespace Lukeraymonddowning\SelfHealingUrls\SlugSanitizers;

use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;

class BaseSlugSanitizer implements SlugSanitizer
{
    public function sanitize(string $slug): string
    {
        return str($slug)
            ->lower()
            ->ascii()
            ->replaceMatches('/[^a-z0-9-_ ]/', '');
    }
}
