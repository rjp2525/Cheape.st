<?php

namespace Cheapest\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description_short',
        'description_long',
        'price',
        'sale_price',
        'url',
        'cart_url',
        'aff_url',
        'aff_cart_url',
        'images',
        'provider',
        'upc',
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['images' => 'json'];

    /**
     * Search for a product.
     *
     * @param  $query
     * @param  string $value
     * @return mixed
     */
    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'LIKE', "%$value%")
            ->orWhere('description_short', 'LIKE', "%$value%")
            ->orWhere('description_long', 'LIKE', "%$value%");
    }
}
