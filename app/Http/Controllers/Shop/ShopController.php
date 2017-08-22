<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Categorie;
use App\Models\Shop\Product;
use App\Models\Shop\ProductReview;

class ShopController extends MainController {

    public function showCategory( Request $request, $cat ) {
        Categorie::showCat( self::$data, $cat, $request );
        self::setTitle( self::$data[ 'cat' ][ 'title' ] );

        return view( 'shop.category', self::$data );
    }

    public function showProduct( Request $request, $cat, $product ) {
        self::$data[ 'back' ] = $request->url();
        Product::getProduct( $product, self::$data );
        if ( !empty( self::$data[ 'product' ] ) ) {
            Product::randomItems( self::$data );
            self::setTitle( self::$data[ 'product' ][ 'title' ] . ' - ' . self::$data[ 'breadcrumb' ][ 1 ][ 'title' ] );
            return view( 'shop.product', self::$data );
        }
        self::setTitle( 'Page not found' );
        return response()->view( 'errors.404', self::$data, 404 );
    }

    public function addToCart( $productId, $count = 1 ) {
        Product::addToCart( $productId, $count );
//        \Cart::destroy();
    }

    public function removeFromCart( $rowId ) {
        Product::removeFromCart( $rowId );
    }

    public function viewCart() {
        Product::getNewProducts( self::$data );
        return view( 'shop.cart', self::$data );
    }

    public function updateCart( $rowId, $count ) {
        Product::updateCart( $rowId, $count );
    }

    public function addRate( Request $request ) {
        ProductReview::addRate( $request );
        if ( empty( $request[ 'back' ] ) )
            return redirect( url( '/' ) );
        return redirect( url( $request[ 'back' ] ) );
    }

}
