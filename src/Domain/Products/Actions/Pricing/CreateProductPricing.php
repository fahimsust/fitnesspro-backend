<?php

namespace Domain\Products\Actions\Pricing;

use App\Api\Admin\Products\Requests\CreateProductRequest;
use Domain\Products\Models\Product\Product;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductPricing
{
    use AsObject;

    public function handle(
        Product $product,
        CreateProductRequest $request,
    ): Collection {
        $values = $request->only([
            'price_reg',
            'price_sale',
            'onsale',
            'min_qty',
            'max_qty',
        ]);

        $rows = Site::select("id")->get()->map(
            fn (Site $site) => ['site_id' => $site->id] + $values
        )->toArray();

        $rows[] = array_merge(['site_id' => null], $values);

        return $product->pricing()->createMany($rows);
    }
}
