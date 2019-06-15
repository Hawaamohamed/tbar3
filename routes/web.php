<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* pages without auth */
Route::get('/', 'tbar3Controller@home');
Route::get('/home', 'tbar3Controller@home');

Route::get('/logout', 'tbar3Controller@logout');
Route::get('/login', 'tbar3Controller@login');
Route::post('/login', 'charityController@login');

Route::get('/register/charity', 'tbar3Controller@registerCharity');
Route::post('/register/charity', 'charityController@registerCharity');

Route::get('/register/user', 'tbar3Controller@registerUser');
Route::post('/register/user', 'donorController@registerUser');


Route::get('/team/info', 'tbar3Controller@aboutUs');
Route::get('/needy/persons', 'tbar3Controller@needyPersons');
// reset password
Route::get('/reset/password', function (){
    return view('resetPassword');
});
Route::post('/reset/password', 'charityController@resetPassword');
Route::get('reset/password/{token}','charityController@reset_password');
Route::get('reset/password/donor/{token}','donorController@reset_password');
Route::post('reset/password/final/{token}','charityController@reset_password_final');
Route::post('reset/password/donor/final/{token}','donorController@reset_password_final');
//end reset password
// charity auth
Route::get( "/profile/{id}" , 'charityController@showProfile' )->name('show') ;

Route::group( ['middleware' => 'charity' ] , function (){

    Route::get('details/{id?}','charityController@details')->name('details');

    /**************************  Update Data charity ***************************/
    Route::get('update_ch/{id?}','UpdataDataCharity@show')->name('update_ch');
    Route::post('updateData','UpdataDataCharity@update');
    /**************************  *********************** ***********************/


    Route::post('/profile/updateProfile', 'photosController@update_profile');
    Route::post('/profile/updateCover', 'photosController@update_cover');
    Route::post('/profile/addPost', 'postsController@store');
    Route::post('/profile/deletePost', 'postsController@destroy');
    Route::get('/profile/editPost/{id}','postsController@edit');
    Route::post('/updatePost/{id}','postsController@update')->name("updatePost");
    Route::post('/deleteImg', 'photosController@deleteImg')->name('deleteImg');

});
/****************** Follow ****************/
Route::post('/needy/persons/follow/', 'followingsController@add');

// donor auth
/* ************* paypal *********************** */
Route::post('/paypal' , 'PaymentController@paypal');
Route::get('/paypal/done' , 'PaymentController@paypalDone') ;
Route::get('/paypal/cancel' , 'PaymentController@paypalCancel') ;
Route::get('/session/{id}', function ($id)
{
    session()->put( "donate" , $id ) ;
});
Route::post('/send/message', 'ChatController@send_message');
Route::post('/get/message', 'ChatController@get_message');