<?php

namespace App\Api\Products\Enums;

enum CategoryPageIncludes: string
{
    case Filters = 'filters';
    case Subcategories = 'categories';
    case Products = 'products';
    case Category = 'category';
    case FeaturedProducts = 'featured_products';
}
