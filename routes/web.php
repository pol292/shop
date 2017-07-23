<?php

Route::group( [ 'prefix' => 'ajax' ], function () {
    Route::get( 'product-list', 'Site\AjaxController@getProductList' );
    Route::post( 'up', 'Site\AjaxController@up' );
} );
Route::group( [ 'prefix' => 'shop' ], function () {
    Route::get( '{cat}', 'Shop\CategorieController@show' );
    Route::get( '{cat}/{item}', 'Shop\ProductController@show' );
} );



#   Dashboard:
Route::group( [ 'prefix' => 'dashboard' ], function () {
    Route::get( '/', 'Dashboard\DashboardController@index' );

#   Dashboard/CMS:

    Route::group( [ 'prefix' => 'CMS' ], function () {

#   Dashboard/CMS/Page:

        Route::resource( 'page', 'Dashboard\CMS\ManagePageController' );


#   Dashboard/CMS/Menu:
        Route::group( [ 'prefix' => 'menu' ], function () {
            Route::get( 'view', 'Dashboard\CMS\ManageMenuController@edit' );
            Route::put( 'update', 'Dashboard\CMS\ManageMenuController@update' );
        } );

#   Dashboard/CMS/Content:
        Route::group( [ 'prefix' => 'content' ], function () {
            Route::post( 'add', 'Dashboard\CMS\ManageContentController@add' );
            Route::put( 'update', 'Dashboard\CMS\ManageContentController@update' );
            Route::put( 'update-sort', 'Dashboard\CMS\ManageContentController@updateSort' );
            Route::delete( 'delete/{id}', 'Dashboard\CMS\ManageContentController@delete' );
        } );
    } );


#   Dashboard/Shop:

    Route::group( [ 'prefix' => 'shop' ], function () {

#   Dashboard/Shop/Category:
        Route::resource( 'category', 'Dashboard\Shop\ManageCategoriesController', [ 'except' => [ 'show' ] ] );
    
#   Dashboard/Shop/Product:
        Route::resource( 'product', 'Dashboard\Shop\ManageProductController', [ 'except' => [ 'show' ] ] );
        
    } );

#   Dashboard/restore:
    Route::group( [ 'prefix' => 'restore' ], function () {
        Route::get( 'view/{id}', 'Dashboard\BackupController@view' );
        Route::get( 'history/{id}', 'Dashboard\BackupController@history' );
        Route::get( '{id}', 'Dashboard\BackupController@restore' );
    } );
} );

Route::get( '/', 'Site\PagesController@index' );
Route::get( '/{url}', 'Site\PagesController@showPage' );

Route::get( '/{any}', 'Site\PagesController@show404' )->where( 'any', '.*' );
