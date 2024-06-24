<?php

namespace Domain\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingPackageSize
 *
 * @property int $id
 * @property string $nickname
 * @property int $length
 * @property int $width
 * @property int $height
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingPackageSize extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_package_sizes';

    protected $casts = [
        'length' => 'int',
        'width' => 'int',
        'height' => 'int',
    ];

    protected $fillable = [
        'nickname',
        'length',
        'width',
        'height',
    ];
}
