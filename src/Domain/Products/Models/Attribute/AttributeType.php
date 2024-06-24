<?php

namespace Domain\Products\Models\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\HasModelUtilities;

class AttributeType extends Model
{
    use HasFactory,
        HasModelUtilities;
    public $timestamps = false;

    protected $table = 'attributes_types';

    protected $fillable = [
        'name',
    ];

    public function attributes()
    {
        return $this->hasMany(
            Attribute::class,
            'type_id'
        );
    }
}
