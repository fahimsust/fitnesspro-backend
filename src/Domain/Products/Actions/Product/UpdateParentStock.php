<?php

namespace Domain\Products\Actions\Product;


use Domain\Products\Models\Product\Product;
use Support\Contracts\AbstractAction;

class UpdateParentStock extends AbstractAction
{
    public function __construct(
        public Product $product,
        public int $qty,
        public string $action = "increment"
    ) {
    }

    public function result(): ?Product
    {
        return $this->product->parent;
    }

    public function execute(): static
    {
        $this->product->loadMissing('parent');

        if (!$this->product->parent)
            return $this;

        $this->product->parent->{$this->action}(
            'combined_stock_qty',
            $this->qty
        );

        return $this;
    }
}
