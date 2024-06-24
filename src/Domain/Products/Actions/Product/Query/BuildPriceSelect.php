<?php

namespace Domain\Products\Actions\Product\Query;

use Domain\Accounts\Models\Account;
use Illuminate\Database\Query\Expression;
use Support\Contracts\AbstractAction;

class BuildPriceSelect extends AbstractAction
{
    public function __construct(
        public ?Account $customer,
        public bool     $bypass_discount = false,
        public bool     $child = false,
        public bool     $get_sale_price = false,
        public bool     $get_reg_price = false,
        public bool     $is_onsale = false,
    )
    {
    }

    public function execute(): string
    {
        return $this->build();
    }

    protected function build(): string
    {
        if ($this->bypass_discount || !$this->customer) {
            return $this->nonDiscountPrice();
        }

        return match (true) {
            $this->customer->hasSiteDiscountLevel() => $this->siteDiscountPrice(),
            $this->customer->hasPercentageDiscountLevel() => $this->percentageDiscountPrice(),
            default => $this->nonDiscountPrice(),
        };
    }

    protected function nonDiscountPrice(): string
    {
        if ($this->child) {
            if ($this->get_sale_price) {
                return 'IF(cpp.onsale = 1, cpp.price_sale, NULL)';
            } else if ($this->get_reg_price) {
                return 'cpp.price_reg';
            } else if ($this->is_onsale) {
                return 'cpp.onsale';
            }

            return 'IF(cpp.onsale = 1, cpp.price_sale, cpp.price_reg)';
        }

        return 'IF(pp.onsale = 1, pp.price_sale, pp.price_reg)';
    }

    protected function siteDiscountPrice(): string
    {
        //use different site pricing
        if ($this->customer->discountLevel->apply_to == "0") {//all products
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, NULL), IF(cpp.onsale = 1, cpp.price_sale, NULL))';
                } else if ($this->get_reg_price) {
                    return 'IF(caltpp.price_reg IS NOT NULL, caltpp.price_reg, cpp.price_reg)';
                } else if ($this->is_onsale) {
                    return 'IF(caltpp.price_reg IS NOT NULL, caltpp.onsale, cpp.onsale)';
                }

                return 'IF(caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, caltpp.price_reg), IF(cpp.onsale = 1, cpp.price_sale, cpp.price_reg))';
            }

            return 'IF(altpp.price_reg IS NOT NULL, IF(altpp.onsale = 1, altpp.price_sale, altpp.price_reg), IF(pp.onsale = 1, pp.price_sale, pp.price_reg))';
        }

        if ($this->customer->discountLevel->apply_to == "1") {//assigned to level
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(cdlp.product_id IS NOT NULL && caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, NULL), IF(cpp.onsale = 1, cpp.price_sale, NULL))';
                } else if ($this->get_reg_price) {
                    return 'IF(cdlp.product_id IS NOT NULL && caltpp.price_reg IS NOT NULL, caltpp.price_reg, cpp.price_reg)';
                } else if ($this->is_onsale) {
                    return 'IF(cdlp.product_id IS NOT NULL && caltpp.price_reg IS NOT NULL, caltpp.onsale, cpp.onsale)';
                }

                return 'IF(cdlp.product_id IS NOT NULL && caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, caltpp.price_reg), IF(cpp.onsale = 1, cpp.price_sale, cpp.price_reg))';
            }

            return 'IF(dlp.product_id IS NOT NULL && altpp.price_reg IS NOT NULL, IF(altpp.onsale = 1, altpp.price_sale, altpp.price_reg), IF(pp.onsale = 1, pp.price_sale, pp.price_reg))';
        }

        if ($this->customer->discountLevel->apply_to == "2") {//not assigned to level
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(cdlp.product_id IS NULL && caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, NULL), IF(cpp.onsale = 1, cpp.price_sale, NULL))';
                } else if ($this->get_reg_price) {
                    return 'IF(cdlp.product_id IS NULL && caltpp.price_reg IS NOT NULL, caltpp.price_reg, cpp.price_reg)';
                } else if ($this->is_onsale) {
                    return 'IF(cdlp.product_id IS NULL && caltpp.price_reg IS NOT NULL, caltpp.onsale, cpp.onsale)';
                }

                return 'IF(cdlp.product_id IS NULL && caltpp.price_reg IS NOT NULL, IF(caltpp.onsale = 1, caltpp.price_sale, caltpp.price_reg), IF(cpp.onsale = 1, cpp.price_sale, cpp.price_reg))';
            }

            return 'IF(dlp.product_id IS NULL && altpp.price_reg IS NOT NULL, IF(altpp.onsale = 1, altpp.price_sale, altpp.price_reg), IF(pp.onsale = 1, pp.price_sale, pp.price_reg))';
        }

        return $this->nonDiscountPrice();
    }

    protected function percentageDiscountPrice(): string
    {
        $perc = $this->customer->discountLevel->action_percentage / 100;
        if ($this->customer->discountLevel->apply_to == "0") {//all products
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(cpp.onsale = 1, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), NULL)';
                } else if ($this->get_reg_price) {
                    return 'round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2)';
                } else if ($this->is_onsale) {
                    return 'cpp.onsale';
                }

                return 'IF(cpp.onsale = 1, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2))';
            }

            return 'IF(pp.onsale = 1, round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2), round(pp.price_reg - (pp.price_reg * ' . $perc . '), 2))';
        }

        if ($this->customer->discountLevel->apply_to == "1") {//assigned to level
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(cpp.onsale = 1, IF(cdlp.product_id IS NOT NULL, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), cpp.price_sale), NULL)';
                } else if ($this->get_reg_price) {
                    return 'IF(cdlp.product_id IS NOT NULL, round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2), cpp.price_reg)';
                } else if ($this->is_onsale) {
                    return 'cpp.onsale';
                }

                return 'IF(cpp.onsale = 1, IF(cdlp.product_id IS NOT NULL, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), cpp.price_sale), IF(cdlp.product_id IS NOT NULL, round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2), cpp.price_reg))';
            }

            return 'IF(pp.onsale = 1, IF(dlp.product_id IS NOT NULL, round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2), pp.price_sale), IF(dlp.product_id IS NOT NULL, round(pp.price_reg - (pp.price_reg * ' . $perc . '), 2), pp.price_reg))';
        }

        if ($this->customer->discountLevel->apply_to == "2") {//not assigned to level
            if ($this->child) {
                if ($this->get_sale_price) {
                    return 'IF(cpp.onsale = 1, IF(cdlp.product_id IS NULL, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), cpp.price_sale), NULL)';
                } else if ($this->get_reg_price) {
                    return 'IF(cdlp.product_id IS NULL, round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2), cpp.price_reg)';
                } else if ($this->is_onsale) {
                    return 'cpp.onsale';
                }

                return 'IF(cpp.onsale = 1, IF(cdlp.product_id IS NULL, round(cpp.price_sale - (cpp.price_sale * ' . $perc . '), 2), cpp.price_sale), IF(cdlp.product_id IS NULL, round(cpp.price_reg - (cpp.price_reg * ' . $perc . '), 2), cpp.price_reg))';
            }

            return 'IF(pp.onsale = 1, IF(dlp.product_id IS NULL, round(pp.price_sale - (pp.price_sale * ' . $perc . '), 2), pp.price_sale), IF(dlp.product_id IS NULL, round(pp.price_reg - (pp.price_reg * ' . $perc . '), 2), pp.price_reg))';
        }

        return $this->nonDiscountPrice();
    }
}
