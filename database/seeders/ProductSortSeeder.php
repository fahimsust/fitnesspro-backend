<?php

namespace Database\Seeders;

use Domain\Products\Models\Product\ProductSortOption;
use Illuminate\Database\Seeder;

class ProductSortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'Price (Low to High)', 'price', 'ASC', 1, 1, 1, null, 0],
            [2, 'Price (High to Low)', 'price', 'desc', 1, 2, 0, null, 0],
            [3, 'Name (A to Z)', 'title', 'asc', 1, 3, 0, null, 0],
            [4, 'Name (Z to A)', 'title', 'desc', 1, 4, 0, null, 0],
            [5, 'Avg. Rating', 'rating', 'desc', 1, 5, 0, null, 0],
            [6, 'Brand (A to Z)', 'brand_name', 'asc', 1, 6, 0, null, 0],
            [7, 'Brand (Z to A)', 'brand_name', 'desc', 1, 7, 0, null, 0],
            [8, 'Product No. (A to Z)', 'product_no', 'ASC', 1, 8, 0, null, 0],
            [9, 'Product No. (Z to A)', 'product_no', 'DESC', 1, 9, 0, null, 0],
            [10, 'Created', 'created', 'desc', 0, 8, 0, null, 0],
            [11, 'Newest', 'pp.published_date', 'desc', 1, 8, 0, null, 0],
            [12, 'Category/Product Rank', 'IFNULL(ranks.rank, 99999999)', 'ASC', 0, 0, 0, 'Default Category Sort', 1],
        ];
        $fields = ['id', 'name', 'orderby', 'sortby', 'status', 'rank', 'isdefault', 'display', 'categories_only'];

        foreach ($rows as $row) {
            ProductSortOption::create(array_combine($fields, $row));
        }
    }
}
