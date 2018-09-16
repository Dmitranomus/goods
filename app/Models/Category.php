<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'alias',
        'parent_id'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
