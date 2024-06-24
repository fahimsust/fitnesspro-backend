<?php

namespace Domain\Products\Models\BookingAs;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingasOption
 *
 * @property int $bookingas_id
 * @property string $options
 *
 * @property BookingAs $bookinga
 *
 * @package Domain\Products\Models\Bookingas
 */
class BookingAsOption extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'bookingas_options';

    protected $casts = [
        'bookingas_id' => 'int',
    ];

    protected $fillable = [
        'bookingas_id',
        'options',
    ];

    public function bookingAs()
    {
        return $this->belongsTo(BookingAs::class, 'bookingas_id');
    }
}
