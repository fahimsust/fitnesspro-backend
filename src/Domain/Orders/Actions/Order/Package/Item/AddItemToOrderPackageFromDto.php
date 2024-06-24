<?php

namespace Domain\Orders\Actions\Order\Package\Item;


use App\Api\Orders\Resources\Order\AddItemToOrderPackageResource;
use Domain\Orders\Actions\CheckItemDtoAvailability;
use Domain\Orders\Actions\CheckItemDtoForRequiredAccessories;
use Domain\Orders\Actions\Order\Package\Accessories\AddAccessoriesToOrderPackage;
use Domain\Orders\Actions\Order\Package\Item\Pricing\CheckAndApplyVolumePricingToOrderItem;
use Domain\Orders\Dtos\AccessoryData;
use Domain\Orders\Dtos\OrderItemDto;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Products\Models\Product\ProductAccessory;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Support\Contracts\AbstractAction;
use Support\Contracts\CanReceiveExceptionCollection;
use Support\Traits\ActionExecuteReturnsStatic;
use Support\Traits\HasExceptionCollection;

class AddItemToOrderPackageFromDto extends AbstractAction
    implements CanReceiveExceptionCollection
{
    use ActionExecuteReturnsStatic,
        HasExceptionCollection;

    private OrderItem|Model $item;
    private Collection $productAccessories;
    private Site $site;
    private Order $order;

    public function __construct(
        public Shipment     $shipment,
        public OrderPackage $package,
        public OrderItemDto $itemDto,
        public bool         $checkAvailability = true,
        public bool         $checkRequiredAccessories = true,
    )
    {
        $this->order = $this->shipment->order;
        $this->site = $this->shipment->order->site;
    }

    public function result(): OrderItem
    {
        return $this->item;
    }

    public function execute(): static
    {
        $this->checkAvailability();
        $this->checkRequiredAccessories();

        DB::beginTransaction();

        $this->item = $this->package
            ->items()
            ->create(
                $this->itemDto
                    ->toModelArray($this->shipment->order_id)
            );

        SaveOptionsForOrderItem::now(
            $this->item,
            $this->itemDto
        );

        SaveCustomFieldValuesForOrderItem::now(
            $this->item,
            $this->itemDto
        );

        CheckAndApplyVolumePricingToOrderItem::run($this->item);

        AddAccessoriesToOrderPackage::run(
            $this->package,
            $this->item,
            $this->itemDto->accessories?->each(
                fn(AccessoryData $accessoryData) => $accessoryData->setProductAccessory(
                    $this->productAccessories->firstWhere(
                        fn(ProductAccessory $productAccessory) => $productAccessory->accessory_id === $accessoryData->productId
                    )
                )
            )
        );

        RemoveOrderItemDtoFromInventory::now($this->itemDto);

        DB::commit();

        return $this;
    }

    public function checkAvailability(): void
    {
        if (!$this->checkAvailability) {
            return;
        }

        CheckItemDtoAvailability::now(
            $this->site,
            $this->itemDto,
            $this->order->account
        );
    }

    public function checkRequiredAccessories(): void
    {
        if (!$this->checkRequiredAccessories) {
            return;
        }

        $this->productAccessories = CheckItemDtoForRequiredAccessories::now(
            $this->itemDto,
        );
    }

    public function resultAsResource(): AddItemToOrderPackageResource
    {
        return new AddItemToOrderPackageResource($this);
    }
}
