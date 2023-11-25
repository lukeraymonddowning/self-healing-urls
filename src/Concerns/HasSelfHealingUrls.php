<?php

namespace Lukeraymonddowning\SelfHealingUrls\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Lukeraymonddowning\SelfHealingUrls\Contracts\SlugSanitizer;

trait HasSelfHealingUrls
{
    public function getRouteKey()
    {
        $actualKey = parent::getRouteKey();
        $selfHealingUrl = "{$this->getSlug($this)}-{$actualKey}";

        return app(SlugSanitizer::class)->sanitize($selfHealingUrl);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $model = parent::resolveRouteBinding(Str::afterLast($value, "-"), $field);

        if ($model === null) {
            return null;
        }

        if ($model->getRouteKey() === $value) {
            return $model;
        }

        $route = request()->route();
        $originalParameters = $route->originalParameters();
        $parameterName = collect($route->originalParameters())
            ->search(fn ($parameterValue) => $parameterValue === $value);

        abort(redirect(route($route->getName(), [...$route->originalParameters(), $parameterName => $model->getRouteKey()])));
    }

    protected function getSlug(self $model): string
    {
        $columnName = property_exists($model, 'slug') ? $model->slug : 'slug';

        return $model->getAttribute($columnName);
    }
}