<?php

namespace Domain\Orders\Actions\Shipping;

use Domain\Distributors\Models\Shipping\DistributorShippingGateway;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Orders\Dtos\Shipping\AvailableShippingMethodDto;
use Domain\Orders\Models\Shipping\ShippingCarrier;
use Domain\Orders\Models\Shipping\ShippingGateway;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Support\Collection;
use Support\Contracts\AbstractAction;
use Support\Dtos\AddressDto;

class GetAvailableShippingMethodsForDistributors extends AbstractAction
{
    public function __construct(
        public int|array  $distributorIds,
        public AddressDto $address,
        public ?float     $targetWeight = null,
        public ?float     $minWeight = null,
        public ?float     $maxWeight = null,
        public ?int       $limitToCarrierId = null,
        public ?int       $limitToGatewayId = null,
    )
    {
    }

    public function execute(): Collection
    {
        $query = \DB::table(ShippingMethod::Table(), "m")
            ->select(
                "m.*",
                \DB::raw("IFNULL(s.override_is_international, m.is_international) as is_international"),
                \DB::raw("IFNULL(s.display, IF(m.display='', m.name, m.display)) as display"),
                "s.id as distributor_shippingmethod_id",
                "s.call_for_estimate",
                "s.flat_use",
                "s.flat_price",
                "s.handling_fee",
                "s.handling_percentage",
                "s.discount_rate",
                "s.distributor_id",
                "c.carrier_code",
                "g.id as gateway_id",
                "g.classname as gateway_class",
            )
            ->join(DistributorShippingMethod::Table() . " as s", "s.shipping_method_id", "m.id")
            ->join(ShippingCarrier::Table() . " as c", "c.id", "m.carrier_id")
            ->join(ShippingGateway::Table() . " as g", "g.id", "c.gateway_id")
            ->join(
                DistributorShippingGateway::Table() . " as dc",
                fn($join) => $join
                    ->on("dc.shipping_gateway_id", "g.id")
                    ->on("dc.distributor_id", "s.distributor_id"),
            )
            ->leftJoin(
                ShippingCarrier::Table() . "_shipto as cst",
                fn($join) => $join
                    ->on("cst.shipping_carriers_id", "c.id")
                    ->on("c.limit_shipto", \DB::raw("1")),
            )
            ->where("m.status", true)
            ->where("c.status", true)
            ->where("g.status", true)
            ->where("s.status", true)
            ->where(
                fn($query) => $query
                    ->where("c.limit_shipto", false)
                    ->orWhere("cst.country_id", $this->address->country_id),
            )
            ->when(
                $this->targetWeight,
                fn($query) => $query
                    ->where(
                        fn($query) => $query
                            ->where("m.weight_limit", ">=", $this->targetWeight)
                            ->orWhere("m.weight_limit", 0.00),
                    )
                    ->where(
                        fn($query) => $query
                            ->where("m.weight_min", "<=", $this->targetWeight)
                            ->orWhere("m.weight_min", 0.00),
                    ),
            )
            ->when(
                $this->minWeight,
                fn($query) => $query
                    ->where(
                        fn($query) => $query
                            ->where("m.weight_limit", ">=", $this->minWeight)
                            ->orWhere("m.weight_limit", 0.00),
                    ),
            )
            ->when(
                $this->maxWeight,
                fn($query) => $query
                    ->where(
                        fn($query) => $query
                            ->where("m.weight_min", "<=", $this->maxWeight)
                            ->orWhere("m.weight_min", 0.00),
                    ),
            )
            ->when(
                is_array($this->distributorIds),
                fn($query) => $query->whereIn("s.distributor_id", $this->distributorIds),
                fn($query) => $query->where("s.distributor_id", $this->distributorIds),
            )
            ->when(
                $this->address->is_residential == 1,
                fn($query) => $query->whereBetween("m.ships_residential", [0, 1]),
                fn($query) => $query->where("m.ships_residential", "!=", 1),
            )
            ->when(
                $this->limitToCarrierId,
                fn($query) => $query->where("c.id", $this->limitToCarrierId),
            )
            ->when(
                $this->limitToGatewayId,
                fn($query) => $query->where("g.id", $this->limitToGatewayId),
            );

//        dd(
//            $query->get()->toArray(),
//            $query->toRawSql(),
//            DistributorShippingMethod::all()->toArray(),
//        );

        return $query
            ->get()
            ->map(
                fn(object $result) => AvailableShippingMethodDto::fromQuery($result),
            );
    }
}
