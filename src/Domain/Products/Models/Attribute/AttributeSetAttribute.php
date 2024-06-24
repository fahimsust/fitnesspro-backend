<?php

namespace Domain\Products\Models\Attribute;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Support\Traits\HasModelUtilities;

class AttributeSetAttribute extends Pivot
{
    public $incrementing = false;
    protected $table = 'attributes_sets_attributes';
	use HasFactory,
        HasModelUtilities;

    protected $casts = [
        'set_id' => 'int',
        'attribute_id' => 'int',
    ];

	public function attribute()
	{
		return $this->belongsTo(Attribute::class);
	}

    public function set()
    {
        return $this->belongsTo(AttributeSet::class, 'set_id');
    }
}
