<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

/*
Route::middleware('jwt.charity')->get('/profile',function (Request $request){

    return \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->toUser();
});
/*/



Route::post('/register/charity','APIController@registerCharity');
Route::post('/register/donor','APIController@registerDonor');
Route::post('/login','APIController@login');
Route::post('/reset/password', 'APIController@resetPassword');
Route::middleware('jwt.charity')->get('/profile','APIController@showProfile');
Route::middleware('jwt.charity')->post('/profile/updateCharity','APIController@updateCharity');
Route::middleware('jwt.charity')->post('/profile/addPost','PostsAPIController@store');
Route::middleware('jwt.charity')->post('/profile/deletePost','PostsAPIController@delete');
Route::middleware('jwt.charity')->post('/profile/updatePost','PostsAPIController@update');
Route::middleware('jwt.charity')->post('/send/message','ChatController@sendMessage');
Route::middleware('jwt.charity')->post('/get/message','ChatController@getMessage');
Route::middleware('jwt.charity')->post('/pull/new/message','ChatController@pull_new_message');
Route::middleware('jwt.charity')->post('/push/new/message','ChatController@push_new_message');
Route::middleware('jwt.charity')->post('/profile/updateProfile','APIController@update_profile');
Route::middleware('jwt.charity')->post('/profile/updateCover','APIController@update_cover');
