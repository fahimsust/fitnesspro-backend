<?php

namespace Support\Traits;

use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

trait ClearsCache
{
    abstract protected function cacheTags(): array;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Model $model) {
            $model->clearCaches();
        });

        static::updated(function (Model $model) {
            $model->clearCaches();
        });
    }

    public function clearCaches(): void
    {
        Cache::tags($this->cacheTags())->flush();
    }
}
