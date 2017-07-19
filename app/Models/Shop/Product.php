<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Product extends Model {

    public static function getProduct( &$product, &$data ) {
        $product = self::where( 'url', $product );
        $product = $product->with( 'sale' )->with( 'images' )->first();

        $data[ 'product' ] = ($product) ? $product->toArray() : '';
        $cat               = Categorie::find( $data[ 'product' ][ 'categorie_id' ] );
        if ( $cat ) {
            $cat                    = $cat->toArray();
            $data[ 'breadcrumb' ][] = [ 'title' => $cat[ 'title' ], 'url' => url( "shop/{$cat[ 'url' ]}" ) ];
        }
        $data[ 'breadcrumb' ][ 'active' ] = $data[ 'product' ][ 'title' ];
    }

    public function sale() {
        return $this->hasOne( 'App\Models\Shop\Sale' );
    }

    public function images() {
        return $this->hasMany( 'App\Models\Shop\ProductImage' );
    }

    public static function getProductList( &$products ) {
        if ( $products = Product::select( 'title' )->get() ) {
            $products = $products->toArray();
            foreach ( $products as $key => $p ) {
                $products[ $key ] = $p[ 'title' ];
            }
        }
    }

    public static function getSearch( &$request, &$data, &$product ) {
        $find = $request[ 'find' ];


        $product       = Product::where( 'title', 'LIKE', "%$find%" )
                ->orWhere( 'article', 'LIKE', "%$find%" );
        $data[ 'cat' ] = [
            'title'   => "Search for $find",
            'article' => "We are found for you {$product->count()} products.",
            'url'     => 'sale',
        ];
    }

    public static function getSale( &$request, &$data, &$product ) {
        $product = Product::has( 'sale' );

        $data[ 'cat' ] = [
            'title'   => 'Sale',
            'article' => 'Sale Sale Sale',
            'url'     => 'sale',
        ];
        $product       = $product->has( 'sale' )->with( 'sale' );
    }

}
