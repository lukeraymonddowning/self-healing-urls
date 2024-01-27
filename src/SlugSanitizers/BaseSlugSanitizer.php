<?php

namespace Lukeraymonddowning\SelfHealingUrls\SlugSanitizers;

use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;

class BaseSlugSanitizer implements SlugSanitizer
{
    public function __construct(
        private readonly string $separator = '-',
        private readonly array $dictionary = ['@' => ''],
    ) {
    }

    public function sanitize(string $slug): string
    {
        return str($slug)->slug(
            separator: $this->separator,
            dictionary: $this->dictionary,
        );
    }
}
