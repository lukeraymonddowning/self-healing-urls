<?php

use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\BaseSlugSanitizer;

it('replaces spaces with hyphens', function () {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize('what are you doing?');

    expect($result)->toBe('what-are-you-doing');
});

it('removes multiple hyphens', function () {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize('what--are------you-doing');

    expect($result)->toBe('what-are-you-doing');
});

it('removes hyphens from the start and end', function () {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize('-what-are-you-doing-');

    expect($result)->toBe('what-are-you-doing');
});

it('makes the slug lowercase', function () {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize('AN-UPPER-CASE-STRING');

    expect($result)->toBe('an-upper-case-string');
});

it('converts ascii to alphabetic', function (string $slug, string $expected) {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize($slug);

    expect($result)->toBe($expected);
})->with([
    ['Köttfärssås-är-gott', 'kottfarssas-ar-gott'],
    ['Fußgängerübergänge', 'fussgangerubergange'],
    ['Æ-æ-Ø-ø-Å-å', 'ae-ae-o-o-a-a'],
    ["Mirëdita-Ç'kemi", 'miredita-ckemi'],
    ["déjà-vu", 'deja-vu'],
]);

it('removes anything that isnt alphanumeric, a dash, underscore or space', function ($badCharacter) {
    $sanitizer = new BaseSlugSanitizer();
    $result = $sanitizer->sanitize($badCharacter);

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