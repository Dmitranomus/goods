Что-то набросал по поводу товаров.

Основные места:
- App\Services\DataUpdater - скачивание данных
- App\Repositories\Categories - список категорий
- App\Repositories\Products - список товаров

Ну поиск понятно, что дубовый, такого в реальности не делают.


Запросы:

1:
```sql
SELECT
    o.id,
    o.title,
    COUNT(op.order_id) AS count
FROM
    orders AS o
    INNER JOIN orders_products AS op ON op.order_id=o.id
GROUP BY
    o.id
```
2:
```sql
SELECT
    o.id,
    o.title,
    COUNT(op.order_id) AS count
FROM
    orders AS o
    INNER JOIN orders_products AS op ON op.order_id=o.id
HAVING
    count > 10
```
3:
```sql
SELECT
    o1.title,
    o2.title
FROM
(
    SELECT
        op1.order1_id,
        op2.order2_id
    FROM
        orders_products AS op1
        INNER JOIN orders_products AS op2 ON op1.product_id=op2.product_id AND op1.order_id > op2.order_id
    GROUP BY
        op1.order_id,
        op2.order_id
    ORDER BY
        COUNT(op1.order_id) DESC,
        COUNT(op2.order_id) DESC
) AS lst
INNER JOIN orders AS o1 ON o1.id=lst.order1_id
INNER JOIN orders AS o2 ON o2.id=lst.order2_id
```
Запросы не проверял, написал навскидку. Вероятны ошибки, особенно в третьем