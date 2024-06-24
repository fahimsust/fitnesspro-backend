<?php

namespace Domain\Orders\Models\Order\Shipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class ShipmentStatus extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'orders_statuses';

    protected $casts = [
        'rank' => 'int',
    ];

    protected $fillable = [
        'name',
        'rank',
    ];

    //    public function orders_shipments()
    //    {
    //        return $this->hasMany(Shipment::class, 'order_status_id');
    //    }
}
