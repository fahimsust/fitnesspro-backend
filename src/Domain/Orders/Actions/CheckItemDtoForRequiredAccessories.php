<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Products\Models\Product\ProductAccessory;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;

class CheckItemDtoForRequiredAccessories extends AbstractAction
{
    private Collection $productAccessories;

    public function __construct(
        public CartItemDto|OrderItemDto $itemDto,
    )
    {
    }

    public function execute(): Collection
    {
        $this->productAccessories = ProductAccessory::query()
            ->where('product_id', $this->itemDto->product->id)
            ->with('accessory')
            ->get();

        if ($this->productAccessories->isEmpty()) {
            return $this->productAccessories;
        }

        $this->productAccessories
            ->filter(
                fn(ProductAccessory $productAccessory) => $productAccessory->required
            )
            ->each(
                function (ProductAccessory $productAccessory) { 
                    $this->itemDto->accessories->firstWhere(
                        fn(AccessoryData $accessoryDto) => $accessoryDto->productId === $productAccessory->accessory_id
                    ) ?? throw new \Exception(__('Required accessory :title missing', [
                        'title' => $productAccessory->accessory->title,
                    ]));
                }
            );

        return $this->productAccessories;
    }
}
