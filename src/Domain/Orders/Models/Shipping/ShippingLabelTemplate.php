<?php

namespace Domain\Orders\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingLabelTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $filename
 * @property string $required_js
 * @property string $required_css
 *
 * @package Domain\Orders\Models\Shipping
 */
class ShippingLabelTemplate extends Model
{
    public $timestamps = false;
    protected $table = 'shipping_label_templates';

    protected $fillable = [
        'name',
        'filename',
        'required_js',
        'required_css',
    ];
}
