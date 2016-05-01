<?php

namespace Cheapest\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Product extends Model
{
    use Eloquence;

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
     * The attributes that can be searched.
     *
     * @var array
     */
    protected $searchableColumns = ['name', 'description_short', 'description_long'];

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

    /**
     * Search for a product with weighted relevancy
     *
     * @param  string $string
     * @return mixed
     */
    public function scopeSearchProducts($query, $string)
    {
        return $query->search('"' . $string . '"', ['name' => 90, 'description_short' => 5, 'description_long' => 5]);
    }
}
