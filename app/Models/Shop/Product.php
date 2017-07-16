<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Product extends Model {

    public function sale() {
        return $this->hasOne( 'App\Models\Shop\Sale' );
    }

    public static function getProductList( &$products ) {
        if ( $products = Product::select( 'title' )->get() ) {
            $products = $products->toArray();
            foreach ( $products as $key => $p ) {
                $products[ $key ] = $p[ 'title' ];
            }
        }
    }

    public static function getSearch(&$request , &$data, &$product) {
        $find = $request[ 'find' ];


        $product         = Product::where( 'title', 'LIKE', "%$find%" )
                ->orWhere( 'article', 'LIKE', "%$find%" );
        $data[ 'cat' ]   = [
            'title'   => "Search for $find",
            'article' => "We are found for you {$product->count()} products.",
            'url'     => 'sale',
        ];
    }

    
    public static function getSale(&$request , &$data, &$product) {
        $product = Product::has( 'sale' );

            $data[ 'cat' ]   = [
                'title'   => 'Sale',
                'article' => 'Sale Sale Sale',
                'url'     => 'sale',
            ];
            $product         = $product->has( 'sale' )->with( 'sale' );
            
    }
}
