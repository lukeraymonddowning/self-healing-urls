<?php

use Illuminate\Support\Facades\Route;
use Tests\Fixtures\Models\Post;
use Tests\Fixtures\Models\PostFactory;

it('can generate a self-healing URL', function () {
    $post = PostFactory::new()->create(['title' => 'A really nice title.']);

    Route::get('posts/{post}', function (Post $post) {})->middleware('web')->name('posts.show');

    $route = route('posts.show', $post);

    expect($route)->toEndWith("a-really-nice-title-{$post->getKey()}");
});
