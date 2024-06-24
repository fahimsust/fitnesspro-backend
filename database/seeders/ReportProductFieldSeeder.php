<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Reports\Models\ReportProductField;

class ReportProductFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Id','p.id'],
            [2,'Title','p.title'],
            [3,'Subtitle','p.subtitle'],
            [4,'Status','p.status'],
            [5,'Product No','p.product_no'],
            [6,'Stock Qty','p.combined_stock_qty'],
            [7,'Default Cost','p.default_cost'],
            [8,'Weight','p.weight'],
            [9,'Created','p.created'],
            [10,'Default Distributor Id','p.default_distributor_id'],
            [11,'Default Distributor Name','d.name'],
            [12,'URL Name','p.url_name'],
            [13,'Meta Title','p.meta_title'],
            [14,'Meta Desc','p.meta_desc'],
            [15,'Meta Keywords','p.meta_keywords'],
            [16,'Inventory Gateway Id','pd.inventory_id'],
            [17,'Summary','pd.summary'],
            [18,'Description','pd.description'],
            [19,'Type Id','pd.type_id'],
            [20,'Type Name','pt.name'],
            [21,'Brand Id','pd.brand_id'],
            [22,'Brand Name','b.name'],
            [23,'Rating','pd.rating'],
            [24,'Views (Past Year)','pd.views_1year'],
            [25,'Orders (Count - All)','pd.orders_all'],
            [26,'Downloadable','pd.downloadable'],
            [27,'Downloadable File','pd.downloadable_file'],
            [28,'Reg. Price','pp.price_reg'],
            [29,'Sale Price','pp.price_sale'],
            [30,'On Sale','pp.onsale'],
            [31,'Min. Qty','pp.min_qty'],
            [32,'Max. Qty','pp.max_qty'],
            [33,'Featured','pp.feature'],
            [34,'Volume Pricing Rule','vpr.name'],
            [35,'Site Status','pp.status']
        ];
        $fields = ['id','name','reference'];

        foreach ($rows as $row) {
            ReportProductField::create(array_combine($fields, $row));
        }
    }
}
