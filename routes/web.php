<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['auth', 'role:administrator']], function () {
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/assign-role/{id}', 'UserController@assignRoles')->name('assign-role');
    Route::post('/assign-role-process', 'UserController@assignRolesProcess')->name('assign-role-process');
    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/create-product', 'ProductController@createProducts')->name('create-product');
    Route::post('/create-product-process', 'ProductController@createProductsProcess')->name('create-product-process');
});

Route::group(['middleware' => ['auth', 'role:production']], function () {
    Route::get('/product-stocks', 'ProductController@companyProductDetails')->name('product-stocks');
    Route::get('/product-requisition-company', 'ProductController@productRecusitionCompany')->name('product-requisition-company');
    Route::get('/product-requisition-form', 'ProductController@createProductRecusition')->name('product-requisition-form');
    Route::post('/product-requisition-process', 'ProductController@productRecusitionProcess')->name('product-requisition-process');
});

Route::group(['middleware' => ['auth', 'role:supplier']], function () {
    Route::get('/product-requisition-supplier', 'ProductController@productRecusitionSupplier')->name('product-requisition-supplier');
    Route::post('/product-requisition-complete-process', 'ProductController@productRecusitionCompleteProcess')->name('product-requisition-complete-process');
});
