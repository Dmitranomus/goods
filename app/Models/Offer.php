<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'price',
        'amount',
        'sales',
        'article',
        'product_id'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
