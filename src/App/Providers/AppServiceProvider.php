<?php

namespace App\Providers;

use Database\Seeders\SiteSeeder;
use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        bcscale(2);

        $this->app->singleton(System::class, function ($app) {
            if (app()->environment('testing')) {
                return System::firstOrFactory();
            }

            return Cache::remember('system-first', 60, fn() => System::first());
        });

        $this->app->singleton(Site::class, function ($app) {
            if (!config('site.id')) {
                throw new \Exception(__('Site config ID missing'));
            }

            if (app()->environment('testing')) {
                return Site::firstOrFactory();
            }

            return Cache::remember(
                'site-first',
                60,
                fn() => Site::with('settings')->find(config('site.id'))
            );
        });

        //have to manually create auth like this for kreait/laravel-firebase:4.1
        $this->app->bind(
            FirebaseAuth::class,
            fn($app) => Firebase::auth(),
            true
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(app()->environment(['local', 'testing']));
        Model::unguard();

        $this->loadMigrationsFromSubdirectories();
        $this->morphEnforce();

        Blueprint::macro('autoTimestamps', function(){
            $this->timestamp('created_at')->useCurrent();
            $this->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        Builder::macro('like', function (string|array $columns, ?string $keyword = null) {
            if (!$keyword) {
                return $this;
            }

            return $this->where(
                function (Builder $query) use ($columns, $keyword) {
                    foreach (is_array($columns) ? $columns : [$columns] as $column) {
                        $query->orWhere($column, 'LIKE', "%{$keyword}%");
                    }
                }
            );
        });
    }

    private function loadMigrationsFromSubdirectories(): void
    {
        $mainPath = database_path('migrations');
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }

    private function morphEnforce()
    {
        Relation::enforceMorphMap([
            ProductReviewItem::ATTRIBUTE->value => AttributeOption::class,
            ProductReviewItem::PRODUCT->value => Product::class,
        ]);
    }
}
