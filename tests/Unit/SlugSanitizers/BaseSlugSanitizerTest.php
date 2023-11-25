<?php

use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\BaseSlugSanitizer;

it('makes the slug lowercase', function () {
    $sanitzer = new BaseSlugSanitizer();
    $result = $sanitzer->sanitize('AN-UPPER-CASE-STRING');

    expect($result)->toBe('an-upper-case-string');
});

it('removes anything that isnt alphanumeric, a dash, underscore or space', function ($badCharacter) {
    $sanitzer = new BaseSlugSanitizer();
    $result = $sanitzer->sanitize($badCharacter);

    expect($result)->toBe('');
})->with([
    '!',
    '*',
    '@',
    '.',
    '>',
    '<',
    '\\',
    '/',
    '?',
    '{',
    '}',
    '%',
    '.',
]);
