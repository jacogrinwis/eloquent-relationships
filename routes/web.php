<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', \App\Livewire\ProductListPage::class)->name('products');
