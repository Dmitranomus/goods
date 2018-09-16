<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'image',
        'description',
        'first_invoice',
        'url',
        'price',
        'amount'
    ];

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
