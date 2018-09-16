<?php

Route::get('/', 'Products@list')->name('home');

Route::get('/category/{id}', function (\App\Http\Controllers\Products $products, $id) {
    return $products->list($id);
})->where('id', '[0-9]+')->name('category');

Route::get('/search', function (\App\Http\Controllers\Products $products) {
    $word = isset($_GET['word']) ? $_GET['word'] : null;
    return $products->list(null, $word);
})->name('search');
