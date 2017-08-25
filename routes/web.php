<?php

Route::group( [ 'prefix' => 'ajax', 'namespace' => 'Site' ], function () {
    Route::get( 'product-list', 'AjaxController@getProductList' );
    Route::post( 'up', 'AjaxController@up' );
} );

Route::group( [ 'prefix' => 'user', 'middleware' => [ 'guest' ], 'namespace' => 'Site' ], function () {
    Route::get( 'register', 'UserController@register' );
    Route::post( 'register', 'UserController@postRegister' );
    Route::get( 'login', 'UserController@login' );
    Route::post( 'login', 'UserController@postLogin' );
    Route::get( 'facebook', 'UserController@facebook' );
} );

Route::group( [ 'prefix' => 'user', 'middleware' => [ 'AuthUser' ], 'namespace' => 'Site' ], function () {
    Route::get( 'logout', 'UserController@logout' );
    Route::get( 'link-facebook', 'UserController@facebookLink' );
    Route::get( 'profile', 'UserController@profile' );
    Route::get( 'change-pass', 'UserController@editPass' );
    Route::get( 'order-history', 'UserController@orderHistory' );
    Route::get( 'history/{id}', 'UserController@itemsHistory' );
    Route::post( 'change-pass', 'UserController@editPassPost' );
} );

Route::group( [ 'prefix' => 'shop', 'namespace' => 'Shop' ], function () {
    Route::get( 'checkout', 'ShopController@checkoutCart' )->middleware( 'AuthUser' );
    Route::post( 'checkout/{item}', 'ShopController@checkout' )->middleware( 'AuthUser' );
    Route::get( 'add-to-cart/{id}', 'ShopController@addToCart' );
    Route::get( 'add-to-cart/{id}/{count}', 'ShopController@addToCart' );
    Route::get( 'update-cart/{id}/{count}', 'ShopController@updateCart' );
    Route::get( 'remove-from-cart/{id}', 'ShopController@removeFromCart' );
    Route::get( 'view-cart', 'ShopController@viewCart' );
    Route::post( 'add-rate', 'ShopController@addRate' )->middleware( 'AuthUser' );
    Route::get( '{cat}', 'ShopController@showCategory' );
    Route::get( '{cat}/{item}', 'ShopController@showProduct' );
} );



#   Dashboard:
Route::group( [ 'prefix' => 'dashboard', 'middleware' => [ 'AuthAdmin' ], 'namespace' => 'Dashboard' ], function () {
    Route::get( '/', 'DashboardController@index' );
    Route::resource( 'advertisings', 'ManageAdvertisingsController' );
    Route::resource( 'users', 'ManageUserController' );

#   Dashboard/CMS:

    Route::group( [ 'prefix' => 'CMS', 'namespace' => 'CMS' ], function () {

#   Dashboard/CMS/Page:

        Route::resource( 'page', 'ManagePageController' );


#   Dashboard/CMS/Menu:
        Route::group( [ 'prefix' => 'menu' ], function () {
            Route::get( 'view', 'ManageMenuController@edit' );
            Route::put( 'update', 'ManageMenuController@update' );
        } );

#   Dashboard/CMS/Content:
        Route::group( [ 'prefix' => 'content' ], function () {
            Route::post( 'add', 'ManageContentController@add' );
            Route::put( 'update', 'ManageContentController@update' );
            Route::put( 'update-sort', 'ManageContentController@updateSort' );
            Route::delete( 'delete/{id}', 'ManageContentController@delete' );
        } );
    } );


#   Dashboard/Shop:

    Route::group( [ 'prefix' => 'shop', 'namespace' => 'shop' ], function () {

#   Dashboard/Shop/Category:
        Route::resource( 'category', 'ManageCategoriesController', [ 'except' => [ 'show' ] ] );

#   Dashboard/Shop/Product:
        Route::resource( 'product', 'ManageProductController', [ 'except' => [ 'show' ] ] );
    } );

#   Dashboard/restore:
    Route::group( [ 'prefix' => 'restore' ], function () {
        Route::get( 'view/{id}', 'BackupController@view' );
        Route::get( 'history/{id}', 'BackupController@history' );
        Route::get( '{id}', 'BackupController@restore' );
    } );
} );

Route::get( '/', 'Site\PagesController@index' );
Route::get( '/{url}', 'Site\PagesController@showPage' );

Route::get( '/{any}', 'Site\PagesController@show404' )->where( 'any', '.*' );
