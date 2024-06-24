<?php

namespace Domain\Distributors\Actions;

use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;

class GetCalculatedAvailability extends AbstractAction
{
    public function __construct(
        public int  $distributorId,
        public ?int $stockQty = null,
        public bool $useCache = true,
    )
    {
    }

    public function execute(): ProductAvailability
    {
        if (!$this->useCache) {
            return $this->load();
        }

        return cache()->tags([
            'distributor-availability-id-cache.' . $this->distributorId
        ])
            ->remember(
                'get-calculated-availability.'
                . $this->distributorId
                . '.' . $this->stockQty,
                60 * 60 * 24,
                fn() => $this->load()
            );
    }

    public function load(): ProductAvailability
    {
        $query = ProductAvailability::leftJoinRelationship(
            'distributorAvailability',
            fn($join) => $join->as('distributorAvailability')
                ->where(
                    'distributorAvailability.distributor_id',
                    $this->distributorId
                )
        );

        if (!is_null($this->stockQty)) {
            $query->whereAutoAdjust(true)
                ->where(
                    fn($query) => $query
                        ->whereNull(DB::raw('IFNULL(distributorAvailability.qty_min, products_availability.qty_min)'))
                        ->orWhere(
                            DB::raw('IFNULL(distributorAvailability.qty_min, products_availability.qty_min)'),
                            '<=',
                            $this->stockQty
                        )
                )
                ->where(
                    fn($query) => $query
                        ->whereNull(DB::raw('IFNULL(distributorAvailability.qty_max, products_availability.qty_max)'))
                        ->orWhere(
                            DB::raw('IFNULL(distributorAvailability.qty_max, products_availability.qty_max)'),
                            '>=',
                            $this->stockQty
                        )
                );
        }

        return $query
            ->select(
                'products_availability.id',
                DB::raw('IFNULL(distributorAvailability.display, IFNULL(products_availability.display, products_availability.name)) as display'),
                DB::raw('IFNULL(distributorAvailability.qty_min, products_availability.qty_min) as qty_min'),
                DB::raw('IFNULL(distributorAvailability.qty_max, products_availability.qty_max) as qty_max'),
                'products_availability.auto_adjust'
            )
            ->first()
            ?? throw new ModelNotFoundException(
                __("No product availability matching distributor.")
            );
    }
}
