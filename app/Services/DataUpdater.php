<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DataUpdater
{
    public function update()
    {
        $json = file_get_contents(config('app.data_source_url'));
        $result = json_decode($json, true);
        foreach ($result['products'] as $item) {
            if (!Product::find($item['id'])) {
                DB::transaction(function () use($item) {
                    $product = Product::create($item);

                    foreach ($item['offers'] as $itemOffer) {
                        if (!Offer::find($itemOffer['id'])) {
                            $itemOffer['product_id'] = $item['id'];
                            Offer::create($itemOffer);
                        }
                    }

                    foreach ($item['categories'] as $itemCategory) {
                        if (!($category = Category::find($itemCategory['id']))) {
                            $itemCategory['parent_id'] = $itemCategory['parent'];
                            $category = Category::create($itemCategory);
                        }
                        $product->categories()->attach($category);
                    }
                });
            }
        }
    }
}
