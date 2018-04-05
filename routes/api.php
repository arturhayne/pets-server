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

// preflight to CORS
Route::options('{all}', function () {
    //Trata as requisições OPTIONS preflight
    return \Response::json('{"method":"OPTIONS"}', 200, \Prodeb::getCORSHeaders());
})->where('all', '.*');

Route::get('/', function () {
    return resposen()->json(['status' => 'API_ONLINE']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function () {
    //public area
    Route::post('authenticate', 'AuthenticateController@authenticate');

    Route::post('password/email', 'PasswordController@postEmail');
    Route::post('password/reset', 'PasswordController@postReset');

    Route::group(['prefix' => 'support'], function () {
        Route::get('langs', 'SupportController@langs');
    });

    Route::get('authenticate/check', function () {
        return response()->json(['status' => 'valid']);
    })->middleware('jwt.auth'); //just to check the token


    Route::get('pets/abandoned', 'PetsController@index');

    //authenticated area
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::put('/pets/adopt/{id}', 'PetsController@adopt');
        Route::put('/pets/abandon/{id}', 'PetsController@abandon');
        Route::resource('pets', 'PetsController');

        Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

        Route::put('profile', 'UsersController@updateProfile');

        Route::resource('roles', 'RolesController', ['only' => ['index']]);

        //admin area
        Route::group(['middleware' => ['acl.role:admin']], function () {
            Route::get('audit', 'AuditController@index');
            Route::get('audit/models', 'AuditController@models');

            Route::resource('users', 'UsersController', ['except' => ['updateProfile']]);

            Route::group(['prefix' => 'dinamicQuery'], function () {
                Route::get('/', 'DinamicQueryController@index');
                Route::get('models', 'DinamicQueryController@models');
            });
        });
    });
});
