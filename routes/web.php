<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin section.
|--------------------------------------------------------------------------
*/
Route::group(['prefix'=>'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {

    Route::get('/', ['as' => 'admin_page', 'uses' => 'CategoryController@index']);

    Route::group(['prefix'=>'category'], function () {
        Route::get('/',            ['as' => 'admin_category_list',   'uses' => 'CategoryController@index']);
        Route::get('create',       ['as' => 'admin_category_create', 'uses' => 'CategoryController@create']);
        Route::post('store',       ['as' => 'admin_category_store',  'uses' => 'CategoryController@store']);
        Route::get('edit/{id}',    ['as' => 'admin_category_edit',   'uses' => 'CategoryController@edit'])->where('id','\d+');
        Route::post('update/{id}', ['as' => 'admin_category_update', 'uses' => 'CategoryController@update'])->where('id','\d+');
        Route::post('delete',      ['as' => 'admin_category_delete', 'uses' => 'CategoryController@delete']);
        Route::get('view/{id}',    ['as' => 'admin_category_view',   'uses' => 'CategoryController@view'])->where('id','\d+');
    });

    Route::group(['prefix'=>'product'], function () {
        Route::get('/',            ['as' => 'admin_product_list',   'uses' => 'ProductController@index']);
        Route::get('create',       ['as' => 'admin_product_create', 'uses' => 'ProductController@create']);
        Route::post('store',       ['as' => 'admin_product_store',  'uses' => 'ProductController@store']);
        Route::get('edit/{id}',    ['as' => 'admin_product_edit',   'uses' => 'ProductController@edit'])->where('id','\d+');
        Route::post('update/{id}', ['as' => 'admin_product_update', 'uses' => 'ProductController@update'])->where('id','\d+');
        Route::post('delete',      ['as' => 'admin_product_delete', 'uses' => 'ProductController@delete']);
        Route::get('view/{id}',    ['as' => 'admin_product_view',   'uses' => 'ProductController@view'])->where('id','\d+');
    });

    Route::group(['prefix'=>'order'], function () {
        Route::get('/',            ['as' => 'admin_order_list',   'uses' => 'OrderController@index']);
        Route::post('delete',      ['as' => 'admin_order_delete', 'uses' => 'OrderController@delete']);
    });

    Route::group(['prefix'=>'pages'], function () {
        Route::get('/',            ['uses' => 'PageController@index'])->name('admin_page_list');
        Route::get('create',       ['uses' => 'PageController@create'])->name('admin_page_create');
        Route::post('store',       ['uses' => 'PageController@store'])->name('admin_page_store');
        Route::get('edit/{id}',    ['uses' => 'PageController@edit'])->name('admin_page_edit');
        Route::post('update/{id}', ['uses' => 'PageController@update'])->name('admin_page_update');
        Route::post('delete',      ['uses' => 'PageController@delete'])->name('admin_page_delete');
        Route::get('view/{id}',    ['uses' => 'PageController@view'])->name('admin_page_view');
    });
});
