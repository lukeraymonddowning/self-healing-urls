<?php

namespace Lukeraymonddowning\SelfHealingUrls\SlugSanitizers;

use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;

class KebabSlugSanitizer implements SlugSanitizer
{
    public function __construct(
        private SlugSanitizer $decoratedSanitizer = new BaseSlugSanitizer(),
    ) {
    }

    public function sanitize(string $slug): string
    {
        return str($this->decoratedSanitizer->sanitize($slug))
            ->kebab()
            ->replaceMatches('/[-]{2,}/', '-');
    }
}
