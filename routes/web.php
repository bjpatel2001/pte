<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/', 'Auth\LoginController@welcome')->name('welcome');

Route::get('/backend', function () {
    return Redirect::to('login');
});

Auth::routes();
Route::get('after_reset_password', ['uses' => 'Api\LoginController@afterResetPassword']);
Route::get('/maintanance', function (){
    return view('maintanance');
});

/*
 *  Dashboard Management
 *  get file from resources/views
 * */

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);


/**
 * Payment Class and controller
 * */
Route::group(['prefix' => 'pte'], function () {
    //Route::post('/payment', 'PteController@payment');
    Route::post('/payment-request', 'PteController@createPaymentRequest');
    Route::post('/redirect', 'PteController@checkPaymentStatus');
});
/*
 *  Role Management
 *  get files from resources/views/role
 * */

Route::group(array('prefix' => 'role','Permission'=>"role_manage", 'as' => 'role::'), function() {
    Route::any('list', ['as' => 'indexRole', 'uses' => 'RoleController@index']);
    Route::get('add', ['as' => 'createRole', 'uses' => 'RoleController@create']);
    Route::get('edit/{id}', ['as' => 'editRole', 'uses' => 'RoleController@edit']);
    Route::post('store', ['as' => 'storeRole', 'uses' => 'RoleController@store']);
    Route::post('update', ['as' => 'updateRole', 'uses' => 'RoleController@update']);
});

/*
 *  Permission Management
 *  get files from resources/views/permission
 * */

Route::group(array('prefix' => 'permission','Permission'=>"permission_management", 'as' => 'permission::'), function() {
    Route::any('list', ['as' => 'indexPermission', 'uses' => 'PermissionController@index']);
    Route::get('add', ['as' => 'createPermission', 'uses' => 'PermissionController@create']);
    Route::get('edit/{id}', ['as' => 'editPermission', 'uses' => 'PermissionController@edit']);
    Route::post('store', ['as' => 'storePermission', 'uses' => 'PermissionController@store']);
    Route::post('update', ['as' => 'updatePermission', 'uses' => 'PermissionController@update']);
});

/*
 *  User Management
 *  get files from resources/views/permission
 * */
Route::get('/change-password', ['uses' => 'UserController@changePassword']);
Route::post('/update_password', ['uses' => 'UserController@updatePassword']);
Route::group(array('prefix' => 'user','Permission'=>"user_management", 'as' => 'user::'), function() {
    Route::any('list', ['as' => 'indexUser', 'uses' => 'UserController@index']);
    Route::get('add', ['as' => 'createUser', 'uses' => 'UserController@create']);
    Route::get('profile', ['uses' => 'UserController@profile']);
    Route::get('edit/{id}', ['as' => 'editUser', 'uses' => 'UserController@edit']);
    Route::post('delete', ['as' => 'deleteUser', 'uses' => 'UserController@delete']);
    Route::post('store', ['as' => 'storeUser', 'uses' => 'UserController@store']);
    Route::post('update', ['as' => 'updateUser', 'uses' => 'UserController@update']);
    Route::post('change_status', ['uses' => 'UserController@changeStatus']);
    Route::post('datatable', ['uses' => 'UserController@datatable']);
});


Route::group(['prefix' => 'voucher'], function () {

    Route::any('/list', 'PromoController@index')->name('promoPromo');
    Route::get('/add/{flag?}', 'PromoController@create')->name('createPromo');
    Route::get('/profile', 'PromoController@profile');
    Route::get('/edit/{id}/{flag?}', 'PromoController@edit')->name('editPromo');
    Route::get('/log/{id}', 'PromoController@log')->name('logPromo');
    Route::post('/delete', 'PromoController@delete')->name('deletePromo');
    Route::post('/store', 'PromoController@store')->name('storePromo');
    Route::post('/update', 'PromoController@update')->name('updatePromo');
    Route::post('/change_status', 'PromoController@changeStatus');
    Route::post('/datatable', 'PromoController@datatable');
    

});


Route::group(['prefix' => 'enquiry'], function () {

    Route::any('/list', 'EnquiryController@index');
    Route::post('/datatable', 'EnquiryController@datatable');
});

Route::group(['prefix' => 'prize'], function () {
    Route::get('/add', 'PrizeController@create');
    Route::post('/store', 'PrizeController@store');
    Route::post('/update', 'PrizeController@update');
});

Route::group(['prefix' => 'detail'], function () {
    Route::get('/add', 'DetailController@create');
    Route::post('/store-prize', 'DetailController@storePrize');
    Route::post('/store-title', 'DetailController@storeTitle');
 });

Route::group(['prefix' => 'offline'], function () {
    Route::any('/list', 'OfflinePaymentController@index');
    Route::get('/add-new-agent', 'OfflinePaymentController@addNewAgentPayment');
    Route::get('/add-existing-agent-payment', 'OfflinePaymentController@addExistingAgentPayment');
    Route::post('/store-new-agent-payment', 'OfflinePaymentController@storeNewAgentPayment');
    Route::post('/store-existing-agent-payment', 'OfflinePaymentController@storeExistingAgentPayment');
    Route::post('/datatable', 'OfflinePaymentController@datatable');
    Route::post('/delete', 'OfflinePaymentController@delete');
});