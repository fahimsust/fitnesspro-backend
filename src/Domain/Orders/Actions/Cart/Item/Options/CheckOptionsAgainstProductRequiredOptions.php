<?php

namespace Domain\Orders\Actions\Cart\Item\Options;

use Domain\Products\Models\Product\Option\ProductOption;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckOptionsAgainstProductRequiredOptions
{
    use AsObject;

    public array $options = [];

    public function handle(
        int $productId,
        array $options
    ) {
        $this->options = $options;

        ProductOption::select('id', 'display')
            ->whereProductId($productId)
            ->required()
            ->get()
            ->each(
                fn (ProductOption $option) => $this->checkOption($option)
            );
    }

    private function checkOption(ProductOption $option)
    {
        if (is_array($this->options[$option->id])) {
            if (count($this->options[$option->id]) > 0) {
                return;
            }

            $this->optionException($option);
        }

        if (isset($this->options[$option->id]) && ! empty($this->options[$option->id])) {
            return;
        }

        $this->optionException($option);
    }

    private function optionException(ProductOption $option)
    {
        throw new \Exception(__('Please select a :display', [
            'display' => $option->display,
        ]));
    }
}
