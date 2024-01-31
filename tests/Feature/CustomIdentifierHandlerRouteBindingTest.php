<?php

use Illuminate\Support\Facades\Route;
use Lukeraymonddowning\SelfHealingUrls\Contracts\IdentifierHandler;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;
use Lukeraymonddowning\SelfHealingUrls\SlugSanitizers\BaseSlugSanitizer;
use Tests\Fixtures\Handlers\UnderscoreIdentifierHandler;
use Tests\Fixtures\Models\Post;
use Tests\Fixtures\Models\PostFactory;
use Tests\Fixtures\Providers\CustomServiceProvider;

it('registers and uses the custom service provider', function () {
    expect($this->app->providerIsLoaded(CustomServiceProvider::class))->toBeTrue()
        ->and(resolve(SlugSanitizer::class))->toEqual(new BaseSlugSanitizer(separator: '_'))
        ->and(resolve(IdentifierHandler::class))->toBeInstanceOf(UnderscoreIdentifierHandler::class);
});

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

    $this->get('/posts/'.$post->getKey().'_this_is_bogus')
        ->assertRedirect(route('posts.show', $post));
});

it('redirects to the correct URL preserving query string if the slug is malformed', function () {
    $post = PostFactory::new()->create();

    Post::query()->paginate()->withQueryString();

    Route::get('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.show');

    $queryString = '?test=string';

    $this->get('/posts/'.$post->getKey().'_this_is_bogus'.$queryString)
        ->assertRedirect(route('posts.show', $post).$queryString);
});

it('can redirect to non-get route', function () {
    $post = PostFactory::new()->create();

    Route::put('posts/{post}', function (Post $post) {
    })->middleware('web')->name('posts.update');

    $this->put('/posts/'.$post->getKey().'_this_is_bogus')
        ->assertRedirect(route('posts.update', $post));
});
