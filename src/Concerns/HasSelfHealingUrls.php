<?php

namespace Lukeraymonddowning\SelfHealingUrls\Concerns;

use Illuminate\Support\Str;
use Lukeraymonddowning\SelfHealingUrls\Contracts\Rerouter;
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
        $model = parent::resolveRouteBinding(Str::afterLast($value, '-'), $field);

        if ($model === null) {
            return null;
        }

        if ($model->getRouteKey() === $value) {
            return $model;
        }

        app(Rerouter::class)->reroute($value, $model->getRouteKey());
    }

    protected function getSlug(self $model): string
    {
        $columnName = property_exists($model, 'slug') ? $model->slug : 'slug';

        return $model->getAttribute($columnName);
    }
}
