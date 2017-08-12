<?php

Route::get( 'test', function() {
    $files = File::allFiles( public_path().DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR.'up' );
    dd($files[0]->getFilename());
} );

Route::group( [ 'prefix' => 'ajax' ], function () {
    Route::get( 'product-list', 'Site\AjaxController@getProductList' );
    Route::post( 'up', 'Site\AjaxController@up' );
} );
Route::group( [ 'prefix' => 'shop' ], function () {
    Route::get( 'add-to-cart/{id}', 'Shop\ShopController@addToCart' );
    Route::get( 'add-to-cart/{id}/{count}', 'Shop\ShopController@addToCart' );
    Route::get( 'update-cart/{id}/{count}', 'Shop\ShopController@updateCart' );
    Route::get( 'remove-from-cart/{id}', 'Shop\ShopController@removeFromCart' );
    Route::get( 'view-cart', 'Shop\ShopController@viewCart' );
    Route::get( '{cat}', 'Shop\ShopController@showCategory' );
    Route::get( '{cat}/{item}', 'Shop\ShopController@showProduct' );
} );



#   Dashboard:
Route::group( [ 'prefix' => 'dashboard' ], function () {
    Route::get( '/', 'Dashboard\DashboardController@index' );
    Route::resource( 'advertisings', 'Dashboard\ManageAdvertisingsController' );

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