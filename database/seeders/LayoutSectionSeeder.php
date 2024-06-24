<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Sites\Models\Layout\LayoutSection;

class LayoutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'left','Left Sidebar',1],
            [2,'right','Right Sidebar',1],
            [3,'body','Body',1],
            [4,'body_header','Body (Header)',1],
            [5,'body_footer','Body (Footer)',1],
            [6,'body_category_header','Body (Category Header)',1],
            [7,'head','Head',0],
            [8,'header','Header',1],
            [9,'footer','Footer',100],
            [10,'foot','Foot',110],
            [11,'left_top','Left Sidebar (Top)',1],
            [12,'left_bottom','Left Sidebar (Bottom)',1],
            [13,'right_top','Right Sidebar (Top)',1],
            [14,'right_bottom','Right Sidebar (Bottom)',1],
            [15,'header_left','Header (Left)',1],
            [16,'header_right','Header (Right)',1],
            [17,'footer_left','Footer (Left)',1],
            [18,'footer_right','Footer (Right)',1],
            [19,'misc_1','Miscellaneous 1',1],
            [20,'misc_2','Miscellaneous 2',1],
            [21,'productdetails_zoom','Product Details Zoom',1],
            [22,'search_results_top','Search Results (Top)',1],
            [23,'search_results_bottom','Search Results (Bottom)',1],
            [24,'category_products_top','Category Products (Top)',1],
            [25,'category_products_bottom','Category Products (Bottom)',1],
            [26,'productdetails_zoom_pre','Product Details Zoom (Before)',1],
            [27,'productdetails_zoom_post','Product Details Zoom (After)',1],
            [28,'alternate1','Alternate #1',0],
            [29,'alternate2','Alternate #2',0],
            [30,'alternate3','Alternate #3',0],
            [31,'alternate4','Alternate #4',0],
            [32,'alternate5','Alternate #5',0],
            [33,'account_lobby','Account Lobby',1],
            [34,'body_top','Body (Top)',1],
            [35,'body_bottom','Body (Bottom)',1]
        ];
        $fields = ['id','name','display','rank'];

        foreach ($rows as $row) {
            LayoutSection::create(array_combine($fields, $row));
        }
    }
}
