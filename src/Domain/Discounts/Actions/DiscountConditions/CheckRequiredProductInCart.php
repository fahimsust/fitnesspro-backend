<?php

namespace Domain\Discounts\Actions\DiscountConditions;

use Domain\Discounts\Contracts\CartConditionCheck;
use Domain\Discounts\Traits\ChecksCartItemsForDiscountCondition;
use Domain\Orders\Dtos\CartItemDto;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CheckRequiredProductInCart extends CartConditionCheck
{
    use ChecksCartItemsForDiscountCondition;

    private Collection $products;

    public function check(): bool
    {
        $this->products()
            ->whenEmpty(
                fn() => $this->failed(
                    __('No products found'),
                    Response::HTTP_NOT_ACCEPTABLE
                )
            );

        if ($this->condition->required_qty_type->isCombined()) {
            $this->neededQty = $this->condition->required_qty_combined;

            return $this->checkConditionWithRequiredQtyCombined();
        }

        return $this->checkConditionWithRequiredQtyIndividual();
    }

    protected function checkConditionWithRequiredQtyCombined(): bool
    {
        $this->products()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                $this->checkStatusAgainstItems(...)
            );

        return $this->completeCheckConditionWithRequiredQtyCombined();
    }

    protected function checkConditionWithRequiredQtyIndividual(): bool
    {
        $this->success = null;

        $this->products()
            ->takeUntil(fn() => $this->success != null)
            ->each(
                function (Product $product) use (&$success) {
                    $this->resetFoundAndNeededQty(
                        $product->pivot->required_qty
                    );

                    $this->checkStatusAgainstItems($product);

                    $this->setCheckRequiredQtyIndividualSuccess(
                        $product->pivot->required_qty
                    );
                }
            );

        return $this->checkSetSuccessIfMatchAll();
    }

    protected function checkStatusAgainstItems(
        Product $product
    ): void
    {
        $this->cart->itemsCached()
            ->takeUntil(fn() => $this->neededQty == 0)
            ->each(
                fn(CartItem $item) => $this->checkApplyStatusAgainstItem(
                    $item,
                    $product,
                )
            );
    }

    protected function checkApplyStatusAgainstItem(
        CartItem $item,
        Product  $product,
    ): void
    {
        $cartItemDto = CartItemDto::fromCartItem($item);

        info(
            "Checking " .
            $cartItemDto->product->title .
            " product id " .
            $item->product_id .
            (($this->condition->checkEquals()) ? '=' : '!=') .
            $product->id
        );

        if ($item->isAutoAdded()) {
            info(" - is auto added");
            return;
        }

        if (
            ($this->condition->checkEquals() && $item->product_id == $product->id)
            ||
            (!$this->condition->checkEquals() && $item->product_id != $product->id)
        ) {
            $useQty = $this->applyUseQtyForConditionProduct($item);

            if ($useQty > 0) {
                $this->checkerData->useForRuleProduct(
                    $this->condition->rule,
                    $item,
                );
            }

            return;
        }

        info(" - doesn't match");
    }

    private function products(): Collection
    {
        return $this->products ??= $this->condition
            ->cachedRelation('products');
    }
}
