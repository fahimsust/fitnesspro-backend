<?php

namespace Domain\Resorts\Models;

use function config;
use Domain\AdminUsers\Models\User;
use Domain\Content\Models\Image;
use Domain\Locales\Models\Country;
use Domain\Photos\Models\Photo;
use Domain\Photos\Models\PhotoAlbum;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Support\Traits\HasModelUtilities;

class Resort extends Model
{
    use HasFactory,
        HasModelUtilities,
        HasRelationships;

    public $incrementing = false;

    protected $table = 'resorts';

    protected $htmllatin_decode = [
        'description',
        'comments',
        'notes',
        'details',
        'schedule_info',
        'suz_comments',
        'giftfund_info',
        'transfer_info',
        'contact_city',
        'contact_addr',
        'mgr_lname',
        'mgr_fname',
        'concierge_name',
        'fpt_manager_name',
        'mobile_background_image',
    ];

//    protected $with = ['attributeOption'];
    protected $hidden = ['attribute_option_id'];

    protected $appends = ['name', 'id'];

    protected $primaryKey = 'attribute_option_id';

    public function scopeJoinAttributeOption($query)
    {
        return $query
            ->join('attributes_options', $this->table . '.attribute_option_id', '=', 'attributes_options.id')
            ->whereRaw('attributes_options.id IS NOT NULL')
            ->where('attributes_options.status', 1);
    }

    public static function find($id)
    {
        return static::whereAttributeOptionId($id)->first();
    }

    public function getNameAttribute()
    {
        $attributeOption = $this->attributeOption;

        if ($attributeOption) {
            return $attributeOption->display;
        }

        return '';
    }

    public function getRouteKeyName()
    {
        return 'attribute_option_id';
    }

    public function getIdAttribute()
    {
        return $this->attribute_option_id;
    }

//    public function getDescriptionAttribute($value)
//    {
//        return $this->htmlLatinDecode($value);
//    }

    public function airport()
    {
        return $this->hasOne(
            AttributeOption::class,
            'id',
            'airport_id'
        );
    }

    public function attributeOption()
    {
        return $this->belongsTo(
            AttributeOption::class,
            'attribute_option_id',
            'id'
        );
    }

    public function country()
    {
        return $this->belongsTo(
            Country::class,
            'contact_country_id',
            'id'
        );
    }

    public function type()
    {
        return $this->hasOne(
            AttributeOption::class,
            'id',
            'resort_type'
        );
    }

    public function fptManager()
    {
        return $this->hasOne(User::class, 'id', 'fpt_manager_id');
    }

    public function amenities()
    {
        //todo
        return $this->hasManyThrough(
            Amenity::class,
            ResortAmenity::class,
        );
    }

    public function albums()
    {
        $photoAlbumTable = PhotoAlbum::table();

        return $this->hasManyThrough(
            PhotoAlbum::class,
            ProductAttribute::class,
            'option_id',
            'type_id',
            null,
            'product_id'
        )
            ->where("{$photoAlbumTable}.type", '=', 2);
    }

    public function photos()
    {
        $photoTable = Photo::table();
        $photoAlbumTable = PhotoAlbum::table();

        return $this->albums()
            ->join($photoTable, "{$photoTable}.album", '=', "{$photoAlbumTable}.id")
            ->select("{$photoTable}.*");
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductAttribute::class,
            'option_id',
            'id',
            'attribute_option_id',
            'product_id'
        );
    }

    public function images(bool|null $showInGallery = true)
    {
        $query = $this->hasManyDeep(
            Image::class,
            [
                ProductAttribute::class,
                Product::class,
                ProductImage::class,
            ],
            [
                'option_id',
                'id',
                'product_id',
                'id',
            ],
            [
                'attribute_option_id',
                'product_id',
                'id',
                'image_id',
            ],
        )
            ->withPivot(ProductImage::table())
            ->where(Product::table() . '.status', true)
            ->orderBy('rank');

        return is_null($query)
            ? $query
            : $query->where('show_in_gallery', $showInGallery);
    }

    public function specialties()
    {
        return $this
            ->hasManyDeep(
                AttributeOption::class,
                [
                    ProductAttribute::class . ' as resort_product_attribute',
                    Product::class,
                    ProductAttribute::class,
                ],
                ['option_id', 'id', 'product_id', 'id'],
                ['attribute_option_id', 'product_id', 'id', 'option_id']
            )
            ->where(AttributeOption::table() . '.attribute_id', config('trips.specialty_attribute_id'));
    }

    public function limitRelation(string $relation, $limit = 10)
    {
        $this->setRelation($relation, $this->$relation()->limit($limit)->get());
//        return $relation->limit(2)->get();
    }
}
