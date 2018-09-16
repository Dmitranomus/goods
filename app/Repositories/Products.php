<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Products
{
    private const PAGE_SIZE = 20;

    /**
     * Получить список товаров
     *
     * Возвращает PAGE_SIZE товаров с наибольшим количеством продаж
     * Возможны условия - категория и текстовая строка поиска по названию и описанию
     *
     * @param null|int $categoryID
     * @param string $word
     * @return \Illuminate\Support\Collection
     */
    public static function listByConditions($categoryID = null, $word = '')
    {
        $categoryID = (int) $categoryID;

        $products = DB::table('products')
            ->join('offers', 'products.id', '=', 'offers.product_id')
            ->select(DB::raw('products.id, products.title, SUM(offers.sales) AS sales'))
            ->orderBy('sales', 'DESC')
            ->groupBy('products.id')
            ->limit(self::PAGE_SIZE)
        ;

        self::addCategoryCondition($products, $categoryID);

        self::addWordCondition($products, $word);

        return $products->get();
    }

    /**
     * Добавить в запрос условие поиска в категории, если нужно
     *
     * @param $products
     * @param null|int $categoryID
     */
    private static function addCategoryCondition($products, $categoryID)
    {
        if ($categoryID > 0) {
            $products->join('category_product', 'category_product.product_id', '=', 'products.id');
            $products->join('categories', 'categories.id', '=', 'category_product.category_id');
            $products->where('categories.id', $categoryID);
        }
    }

    /**
     * Добавить в запрос условие поиска текста, если нужно
     *
     * @param $products
     * @param string $word
     */
    private static function addWordCondition($products, string $word)
    {
        if (!empty($word)) {
            $products->where('products.title', 'LIKE', "%$word%");
            $products->orWhere('products.description', 'LIKE', "%$word%");
        }
    }
}
