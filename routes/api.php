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
*/
Route::post( 'test', function ( Request $request ) {

    return $request->file;
} );


Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );

//Auth
Route::group( [ 'prefix' => 'auth', 'namespace' => 'Api\Auth' ], function () {
    Route::post( 'login', 'LoginController@login' );

    Route::post( 'logout', 'LoginController@logout' )->middleware( 'auth:api' )->name( 'logout' );
    Route::post( 'register', 'RegisterController@register' )->name( 'register' );
    Route::post( 'password/email', 'ResetPasswordController@email' );

    Route::get( 'verify/token/{token}', 'VerificationController@verify' )->name( 'verify' );
    Route::post( 'verify/resend', 'VerificationController@resend' )->name( 'verify.resend' );

} );


Route::group( [ 'prefix' => 'v1', 'namespace' => 'Api' ], function () {

    Route::delete( 'clothes', 'Clothing\ClothingController@destroy' );
    Route::apiResource( 'clothes', 'Clothing\ClothingController' );

    Route::delete( 'users', 'User\UserController@destroy' );
    Route::apiResource( 'users', 'User\UserController' );

} );

Route::group( [ 'prefix' => 'admin', 'namespace' => 'Admin' ,'middleware' => ['auth:api']], function () {

    Route::get( 'users/{user_id}/clothes', 'User\UserController@clothes' );
    Route::delete( 'users', 'User\UserController@destroy' );
    Route::resource( 'users', 'User\UserController' );

    Route::delete( 'clothes', 'Clothing\ClothingController@destroy' );
    Route::resource( 'clothes', 'Clothing\ClothingController' );

    Route::post( '/avatar-upload', 'User\UserController@avatarUpload' );
} );