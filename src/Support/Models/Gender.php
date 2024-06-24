<?php

namespace Support\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GiftregistryGender
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 *
 * @package Domain\Accounts\Models\GiftCards
 */
class Gender extends Model
{
    public $timestamps = false;
    //TODO rename table as "genders"; this can be a system wide setting

    protected $table = 'giftregistry_genders';

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'name',
        'status',
    ];
}
