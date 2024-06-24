<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Distributors\Models\Inventory\GatewayField;

class InventoryGatewaysFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,2,'class_name','type_name',0],
            [2,2,'class_name','type_id',1],
            [3,2,'family','brand_id',1],
            [4,1,'categories->web->category->parent->category->parent->category->name','type_name',0],
            [5,1,'categories->web->category->parent->category->parent->category->name','type_id',1],
            [6,1,'keywords->keyword->{0}','brand_id',1],
            [7,1,'categories->web->category->parent->category->parent->category->name','default_category_id',1],
            [8,3,'family','brand_id',1],
            [9,3,'class_name','type_id',1],
            [10,3,'class_name','type_id',1],
            [11,3,'family','brand_id',1],
            [12,4,'Manufacturer->name','brand_id',1],
            [13,4,'custom_field=Product Type','type_id',1],
            [14,4,'Category->name','default_category_id',1],
            [15,5,'family','brand_id',1],
            [16,5,'class_name','type_id',1]
        ];
        $fields = ['id','gateway_id','feed_field','product_field','displayorvalue'];

        foreach ($rows as $row) {
            GatewayField::create(array_combine($fields, $row));
        }
    }
}
