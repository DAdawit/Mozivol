<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SimpleProduct extends Model implements Viewable
{

    use SoftDeletes;
    use HasTranslations;
    use InteractsWithViews;

    public $translatable = ['product_name', 'product_detail','key_features'];

    protected $fillable = [
        'product_name',
        'slug',
        'product_detail',
        'category_id',
        'product_tags',
        'price',
        'offer_price',
        'tax',
        'tax_rate',
        'thumbnail',
        'hover_thumbnail',
        'product_file',
        'status',
        'store_id',
        'brand_id',
        'type',
        'key_features',
        'subcategory_id',
        'child_id',
        'tax_name',
        'free_shipping',
        'featured',
        'cancel_avbl',
        'cod_avbl',
        'return_avbl',
        'tax_name',
        'model_no',
        'sku',
        'hsin',
        'policy_id',
        'actual_offer_price',
        'actual_selling_price',
        'commission_rate',
        'stock',
        'min_order_qty',
        'max_order_qty',
        'external_product_link'
    ];

    public function productGallery()
    {

        return $this->hasMany('App\ProductGallery', 'product_id')->withTrashed();

    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'subcategory_id', 'id');
    }

    public function childcat()
    {
        return $this->belongsTo('App\Grandcategory', 'child_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'simple_pro_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'simple_pro_id');
    }

    public function returnPolicy()
    {
        return $this->belongsTo('App\admin_return_product', 'policy_id','id');
    }

    public function faq()
    {
        return $this->hasMany('App\FaqProduct', 'simple_pro_id');
    }

    public function specs()
    {
        return $this->hasMany('App\ProductSpecifications', 'simple_pro_id');
    }
}
