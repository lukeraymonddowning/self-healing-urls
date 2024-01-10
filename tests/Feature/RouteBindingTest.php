<?php

use Illuminate\Support\Facades\Route;
use Tests\Fixtures\Models\Post;
use Tests\Fixtures\Models\PostFactory;

it('can bind a model from a self-healing URL', function () {
    $this->withoutExceptionHandling();
    $originalPost = PostFactory::new()->create();

    Route::get('posts/{post}', function (Post $post) use ($originalPost) {
        expect($post->getKey())->toBe($originalPost->getKey());

        return response(status: 418);
    })->middleware('web')->name('posts.show');

    $this->get(route('posts.show', $originalPost))->assertStatus(418);
});

it('returns a 404 if the identifier of the URL is not found', function () {
    $originalPost = PostFactory::new()->create();

    Route::get('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.show');

    $route = route('posts.show', $originalPost);
    $originalPost->delete();

    $this->get($route)->assertNotFound();
});

it('redirects to the correct URL if the slug is malformed', function () {
    $post = PostFactory::new()->create();

    Route::get('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.show');

    $this->get('/posts/this-is-bogus-'.$post->getKey())
        ->assertRedirect(route('posts.show', $post));
});

it('redirects to the correct URL preserving query string if the slug is malformed', function () {
    $post = PostFactory::new()->create();

    Post::query()->paginate()->withQueryString();

    Route::get('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.show');

    $queryString = '?test=string';

    $this->get('/posts/this-is-bogus-'.$post->getKey().$queryString)
        ->assertRedirect(route('posts.show', $post).$queryString);
});

it('can redirect to non-get route', function () {
    $post = PostFactory::new()->create();

    Route::put('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.update');

    $this->put('/posts/this-is-bogus-'.$post->getKey())
        ->assertRedirect(route('posts.update', $post));
});
