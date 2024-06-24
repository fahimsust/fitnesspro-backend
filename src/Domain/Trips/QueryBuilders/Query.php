<?php

namespace Domain\Trips\QueryBuilders;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Domain\Locales\Models\Country;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemCustomField;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Orders\Models\Order\OrderItems\OrderItemSentEmail;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\Rule\CategoryRule;
use Domain\Products\Models\Category\Rule\CategoryRuleAttribute;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Resorts\Models\Resort;
use Illuminate\Support\Facades\DB;

class Query
{
    public $builder;

    public function __construct($resortAttributeId)
    {
        $builder = DB::table(OrderItem::table() . ' as op')
            ->join(OrderPackage::table() . ' as pkg', 'pkg.id', '=', 'op.package_id')
            ->join(Shipment::table() . ' as os', 'os.id', '=', 'pkg.shipment_id')
            ->join(ShipmentStatus::table() . ' as shipment_status', 'shipment_status.id', '=', 'os.order_status_id')
            ->join(Order::table() . ' as o', 'o.id', '=', 'op.order_id')
            ->join(Product::table() . ' as p', 'p.id', '=', 'op.product_id')
            ->join(ProductDetail::table() . ' as pd', 'pd.product_id', '=', 'p.id')
            ->join(AttributeOption::table() . ' as ao', 'ao.attribute_id', '=', DB::raw($resortAttributeId))
            ->join(ProductAttribute::table() . ' as pa', function ($join) {
                $join->on('pa.product_id', '=', 'p.id')->on('pa.option_id', '=', 'ao.id');
            })
            ->leftJoin(CategoryRuleAttribute::table() . ' as cra', 'cra.value_id', '=', 'pa.option_id')
            ->leftJoin(CategoryRule::table() . ' as cr', 'cr.id', '=', 'cra.rule_id')
            ->leftJoin(Category::table() . ' as cat', 'cat.id', '=', 'cr.category_id')
            ->leftJoin(OrderItemOptionOld::table() . ' as opo', 'opo.orders_products_id', '=', 'op.id')
            ->leftJoin(CustomForm::table() . ' as form', 'form.name', '=', DB::raw("'Old Resort Date Info'"))
            ->leftJoin(FormSection::table() . ' as forms', 'forms.form_id', '=', 'form.id')
            ->leftJoin(FormSectionField::table() . ' as formsf', 'formsf.section_id', '=', 'forms.id')
            ->leftJoin(OrderItemCustomField::table() . ' as cf', function ($join) {
                $join->on('cf.orders_products_id', '=', 'op.id')
                    ->on('cf.form_id', '=', 'form.id')
                    ->on('cf.section_id', '=', 'forms.id')
                    ->on('cf.field_id', '=', 'formsf.field_id');
            })
            ->leftJoin(ProductOptionValue::table() . ' as pov', function ($join) {
                $join->on('pov.id', '=', 'opo.value_id')
                    ->whereRaw('pov.start_date IS NOT NULL');
            })
            ->leftJoin(Resort::table() . ' as resort', 'resort.attribute_option_id', 'ao.id')
            ->leftJoin(Country::table() . ' as country', 'country.id', 'resort.contact_country_id');

        $builder
            ->selectRaw('o.id as order_id, o.order_no, op.id, p.id as product_id, p.title as product_title, o.site_id, o.account_id, ao.display as resort,' .
                'IFNULL(pov.start_date, SUBSTR(cf.value, 1, 10)) as start_date, IFNULL(pov.end_date, SUBSTR(cf.value, -10)) as end_date, cat.url_name')
            ->addSelect('pd.downloadable', 'pd.downloadable_file')
            ->addSelect('os.order_status_id', 'shipment_status.name as order_status_label')
            ->addSelect('country.id as country_id', 'country.name as country_name', 'resort.description as resort_description');

        $builder->groupByRaw('`ao`.`display`, `pov`.`start_date`, `pov`.`end_date`, `cf`.`value`' .
            ', `cat`.`url_name`, `country`.`id`, `resort`.`description`');

        $this->builder = $builder;
    }

    public function groupByAccountAndProduct(): void
    {
        $group = 'CONCAT(`o`.`account_id`, `p`.`id`)';

        if (config('database.default') === 'sqlite') {
            $group = '"o"."account_id" || "p"."id"';
        }

        $this->builder->groupByRaw($group);
    }

    public function productTypeId($productTypeId)
    {
        $this->builder->where('pd.type_id', '=', $productTypeId);

        return $this;
    }

    public function orderProductSentTemplateId($msgTemplateId)
    {
        $this->builder->leftJoin(OrderItemSentEmail::table() . ' as e', function ($join) use ($msgTemplateId) {
            $join->on('e.orders_products_id', '=', 'op.id')->where('e.email_id', '=', $msgTemplateId);
        }); //e.email_id=

        return $this;
    }

    public function toSql()
    {
        return \Support\Helpers\Query::toSql($this->builder);
    }
}
