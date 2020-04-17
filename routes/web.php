<?php
Route::get('/', 'WelcomeController@index')->name('welcome');
Auth::routes(['register' => false]);
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['auth', 'role:administrator']], function () {
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/create-users', 'UserController@createUsers')->name('create-users');
    Route::post('/create-user-process', 'UserController@createUserProcess')->name('create-user-process');
    Route::delete('/delete-user', 'UserController@deleteUser')->name('delete-user');

    Route::get('/assign-role/{id}', 'UserController@assignRoles')->name('assign-role');
    Route::post('/assign-role-process', 'UserController@assignRolesProcess')->name('assign-role-process');

    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/create-product', 'ProductController@createProducts')->name('create-product');
    Route::post('/create-product-process', 'ProductController@createProductsProcess')->name('create-product-process');
    Route::post('/edit-product', 'ProductController@editProduct')->name('edit-product');
    Route::post('/edit-product-process', 'ProductController@editProductsProcess')->name('edit-product-process');
    Route::delete('/delete-product', 'ProductController@deleteProductsProcess')->name('delete-product');
});

Route::group(['middleware' => ['auth', 'role:production']], function () {
    Route::get('/product-stocks', 'ProductController@companyProductDetails')->name('product-stocks');
    
    Route::get('/product-requisition-company', 'ProductController@productRecusitionCompany')->name('product-requisition-company');
    Route::get('/product-requisition-form', 'ProductController@createProductRecusition')->name('product-requisition-form');
    Route::post('/product-requisition-process', 'ProductController@productRecusitionProcess')->name('product-requisition-process');
    Route::delete('/product-requisition-delete', 'ProductController@deleteProductRecusition')->name('product-requisition-delete');

    Route::get('/product-receives', 'ProductController@companyReceives')->name('product-receives');
    Route::get('/create-product-receives', 'ProductController@createCompanyReceives')->name('create-product-receives');
    Route::post('/product-receives-process', 'ProductController@companyReceivesProcess')->name('product-receives-process');
    Route::delete('/product-receives-delete', 'ProductController@companyReceivesDelete')->name('product-receives-delete');

    Route::get('/receives-report', 'ProductController@companyReceivesReport')->name('receives-report');
    Route::post('/receives-report-process', 'ProductController@companyReceivesReportProcess')->name('receives-report-process');
});

Route::group(['middleware' => ['auth', 'role:supplier']], function () {
    Route::get('/product-requisition-supplier', 'ProductController@productRecusitionSupplier')->name('product-requisition-supplier');
    Route::post('/product-requisition-complete-process', 'ProductController@productRecusitionCompleteProcess')->name('product-requisition-complete-process');
});
