<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class Products extends BaseController
{
    public function list($categoryID = null, $word = '')
    {
        return view('productsList', [
            'products' => \App\Repositories\Products::listByConditions($categoryID, $word)
        ]);
    }
}
