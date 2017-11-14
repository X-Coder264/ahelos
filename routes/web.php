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

Route::get('/email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('/email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');
Route::get('/email-verification-resend', 'Auth\VerificationController@getResendForm');
Route::post('/email-verification-resend/send', 'Auth\VerificationController@resend');

Route::get('/', 'WelcomeController@index');
Route::post('/email', ['as' => 'contact.form', 'uses' => 'ContactMessageController@store']);

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/order', ['as' => 'user.orders.show', 'uses' => 'HomeController@orders_data']);
Route::get('/order/{order}', ['as' => 'user.order.show', 'uses' => 'OrderController@show']);
Route::get('/order/{order}/data', ['as' => 'user.order.get_data', 'uses' => 'OrderController@order_data']);

Route::get('/new-order', 'OrderController@index');
Route::post('/new-order/store', 'OrderController@store');

Route::get('/add-printer', 'AddPrinterController@index');
Route::post('/add-printer/store/{user}', 'PrinterController@store');
Route::delete('/add-printer/delete/{printer}', 'PrinterController@delete');
Route::get('/add-printer/printer/{printer}/add-ink', 'PrinterInkController@show');
Route::post('/add-printer/printer/{printer}/add-ink', 'PrinterInkController@store');
Route::delete('/add-printer/printer/{printer}/delete-ink/{ink}', 'PrinterInkController@delete');

Route::get('/profile', 'ProfileController@index');
Route::patch('/profile/printer/restore/{printer}', 'PrinterController@restore');
Route::patch('/profile/printer/rename/{printer}', 'PrinterController@update');
Route::put('/profile/{id}', 'ProfileController@update');

Route::get('/settings', 'SettingsController@index');
Route::put('/settings/profile/change-password/{user}', 'ProfileController@changePassword');

Route::get('/getAllInkForPrinter/{printer}', 'PrinterInkController@showInks');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

    # Dashboard / Index
    Route::get('/', ['as' => 'dashboard', function (){
        return view('admin.index');
    }]);

    # User Management
    Route::group(array('prefix' => 'users'), function () {
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@index'));
        Route::get('data',['as' => 'users.data', 'uses' => 'UsersController@data']);
        Route::get('create', 'UsersController@create');
        Route::post('create', 'UsersController@store');
        Route::get('{user}/delete', array('as' => 'users.delete', 'uses' => 'UsersController@destroy'));
        Route::get('{user}/confirm-delete', array('as' => 'users.confirm-delete', 'uses' => 'UsersController@getModalDelete'));
        Route::get('{user}/confirm-restore', array('as' => 'users.confirm-restore', 'uses' => 'UsersController@getModalRestore'));
        Route::get('{user}/restore', array('as' => 'users.restore', 'uses' => 'UsersController@getRestore'));
        Route::get('/{user}/orders', ['as' => 'users.order.data', 'uses' => 'UsersController@showOrders']);
        Route::get('{user}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
        Route::post('{user}/passwordreset', array('as' => 'passwordreset', 'uses' => 'UsersController@passwordreset'));
    });
    Route::resource('users', 'UsersController');

    Route::get('all_orders', ['as' => 'orders.show', 'uses' => 'OrderController@getAllOrders']);
    Route::get('order/{order}', ['as' => 'user.order.show', 'uses' => 'OrderController@order_details']);
    Route::patch('order/{order}', ['as' => 'user.order.update', 'uses' => 'OrderController@update']);

    Route::get('emails', ['as' => 'emails.index', 'uses' => 'ContactMessageController@index']);
    Route::get('all_emails', ['as' => 'emails.show', 'uses' => 'ContactMessageController@getAllEmails']);
    Route::get('answer_email/{email}', ['as' => 'email.answer', 'uses' => 'ContactMessageController@show']);
    Route::post('answer_email/{email}', ['as' => 'email.answer', 'uses' => 'ContactMessageController@sendAnswer']);
});