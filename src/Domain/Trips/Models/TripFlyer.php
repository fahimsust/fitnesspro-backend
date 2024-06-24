<?php

namespace Domain\Trips\Models;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Photos\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class TripFlyer extends Model
{
    use HasFactory,
        HasModelUtilities;

    public const CREATED_AT = 'created';

    protected $table = 'trip_flyers';

    protected $guarded = ['id'];

    protected $appends = ['flyer_pdf_url', 'voucher_pdf_url'];

    public function getFlyerPdfUrlAttribute()
    {
        return config('trips.flyer_url')."/modules/fitpro_travelvoucher/flyers/{$this->id}.pdf";
    }

    public function getVoucherPdfUrlAttribute()
    {
        return config('trips.flyer_url')."/modules/fitpro_travelvoucher/vouchers/{$this->orders_products_id}.pdf";
    }

    /**
     * Scope a query to only include Approval status
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', '=', 1);
    }

    public function scopeOrderProductId($query, $orderProductId)
    {
        return $query->where('orders_products_id', '=', $orderProductId);
    }

    public static function FindByOrderProductId($orderProductId)
    {
        return self::orderProductId($orderProductId)->firstOrFail();
    }

    /**
     * Scope a query to only include NOT Approved status
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnapproved($query)
    {
        return $query->where('approval_status', '<', 1);
    }

    /**
     * Get the orderproduct that owns the mods_trip_flyer.
     */
    public function orderProduct()
    {
        return $this->belongsTo(OrderItem::class, 'orders_products_id');
//            ->withDefault(1); //orders_products_id
    }

    /**
     * Get the photo that own the mods_trip_flyer
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');  //photo_id
    }
}
