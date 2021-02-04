<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'product_id', 'amount', 'description', 'in_stock', 'category', 'manufacturer'
    ];
}
