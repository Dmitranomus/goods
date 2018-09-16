<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Categories
{
    private const KEY_CATEGORIES = 'app.categories';

    private const EXPIRE = 60;

    /**
     * Список категорий
     *
     * Категории упорядочены по названию и сгруппированы по категориям верхнего уровня
     * Категория 1
     * Её подкатегория 1
     * Её подкатегория 2
     * ...
     * Категория 2
     * Категория 3
     * Её подкатегория 1
     * ...
     *
     * @return array
     */
    public static function list()
    {
        if (Cache::has(self::KEY_CATEGORIES)) {
            $list = Cache::get(self::KEY_CATEGORIES);
        } else {
            $sql = "
                SELECT
                    IF(list.subcat_id IS NULL, list.cat_id, list.subcat_id) AS id,
                    IF(list.subcat_title IS NULL, list.cat_title, list.subcat_title) AS title,
                    IF(list.subcat_id IS NULL, 1, 0) AS is_top
                FROM
                    (
                        SELECT
                            id AS cat_id,
                            title AS cat_title,
                            null AS subcat_id,
                            null AS subcat_title
                        FROM
                            categories
                        WHERE
                            parent_id IS NULL
                            
                        UNION
                            
                        SELECT
                            cat.id AS cat_id,
                            cat.title AS cat_title,
                            subcat.id AS subcat_id,
                            subcat.title AS subcat_title
                        FROM
                            categories AS cat
                            LEFT JOIN categories AS subcat ON subcat.parent_id=cat.id
                        WHERE
                            subcat.id IS NOT NULL
                    ) AS list
                ORDER BY
                    CONCAT(list.cat_title, IF(list.subcat_title IS NULL, '', list.subcat_title))
            ";

            $list = DB::select($sql);

            Cache::put(self::KEY_CATEGORIES, $list, self::EXPIRE);
        }

        return $list;
    }
}
