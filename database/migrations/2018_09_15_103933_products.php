<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique()->comment('айди товара');
            $table->string('title')->comment('название товара');
            $table->string('image')->comment('ссылка на изображение');
            $table->mediumText('description')->comment('описание товара');
            $table->dateTime('first_invoice')->nullable()->comment('дата первой продажи товара');
            $table->dateTime('last_supplied')->nullable();
            $table->string('category_google')->nullable();
            $table->string('url')->nullable()->comment('ссылка на товар на markethot.ru');
            $table->decimal('price', 9, 2)->comment('минимальная цена товара');
            $table->integer('amount')->unsigned()->comment('количество всех вариаций');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique()->comment('айди вариации');
            $table->decimal('price', 9, 2)->comment('цена вариации');
            $table->integer('amount')->unsigned()->comment('количество вариации товара на складе');
            $table->integer('sales')->nullable()->unsigned()->comment('единиц продано');
            $table->string('article')->nullable()->comment('артикул вариации');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
            $table->primary('id');

        });

        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique()->comment('айди категории');
            $table->string('title')->comment('название категории');
            $table->string('alias')->comment('slug категории, можно использовать в качестве пути для ссылки на категорию');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();
            $table->primary(['category_id', 'product_id']);
            $table->index('category_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('products');

    }
}
