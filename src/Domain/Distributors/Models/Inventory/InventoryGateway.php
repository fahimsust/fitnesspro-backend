<?php

namespace Domain\Distributors\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class InventoryGateway extends Model
{
    use HasFactory,
        HasModelUtilities;
        
    public $timestamps = false;

    protected $table = 'inventory_gateways';

    protected $casts = [
        'status' => 'bool',
        'loadproductsby' => 'int',
    ];

    protected $fillable = [
        'name',
        'class_name',
        'status',
        'loadproductsby',
        'price_fields',
    ];
}
