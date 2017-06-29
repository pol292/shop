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

Route::get( '/', function () {
    return view( 'welcome' );
} );

#   Dashboard:
Route::group( [ 'prefix' => 'dashboard' ], function () {
    Route::get( '/', 'Dashboard\DashboardController@index' );

#   Dashboard/CMS:

    Route::group( [ 'prefix' => 'CMS' ], function () {

#   Dashboard/CMS/Page:

        Route::resource( 'page', 'Dashboard\CMS\ManagePageController' );

#   Dashboard/CMS/Content:

        Route::group( [ 'prefix' => 'content' ], function () {
            Route::post( 'add', 'Dashboard\CMS\ManageContentController@add' );
            Route::put( 'update', 'Dashboard\CMS\ManageContentController@update' );
            Route::put( 'update-sort', 'Dashboard\CMS\ManageContentController@updateSort' );
            Route::delete( 'delete/{id}', 'Dashboard\CMS\ManageContentController@delete' );
        } );
    } );
    Route::group( [ 'prefix' => 'restore' ], function () {
        Route::get( 'show/{type}', 'Dashboard\BackupController@show' );
        Route::get( '{id}', 'Dashboard\BackupController@restore' );
    } );
} );


Route::get( '/{url}', 'Site\PagesController@showPage' );
