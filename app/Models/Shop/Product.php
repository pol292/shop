<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Product extends Model {

    public static function getProduct( &$product, &$data ) {
        $product = self::where( 'url', $product );
        $product = $product->with( 'images' )->first();

        $data[ 'product' ] = ($product) ? $product->toArray() : '';
        $cat               = Categorie::find( $data[ 'product' ][ 'categorie_id' ] );
        if ( $cat ) {
            $cat                    = $cat->toArray();
            $data[ 'breadcrumb' ][] = [ 'title' => $cat[ 'title' ], 'url' => url( "shop/{$cat[ 'url' ]}" ) ];
        }
        $data[ 'breadcrumb' ][ 'active' ] = $data[ 'product' ][ 'title' ];
    }

    public function category() {
        return $this->hasOne( 'App\Models\Shop\Categorie', 'id', 'categorie_id' );
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
        $product = Product::where( 'sale', '>', '0' );

        $data[ 'cat' ] = [
            'title'   => 'Sale',
            'article' => 'Sale Sale Sale',
            'url'     => 'sale',
        ];
        $product       = $product->where( 'sale', '>', '0' );
    }

    public static function getIndexProducts( &$data ) {
        $data[ 'max_discount' ] = self::max( 'sale' );
        $new = self::orderBy( 'created_at', 'DESC' )
                ->where( 'stock', '>', '0' )
                ->limit( 5 )
                ->with( 'category' )
                ->get();
        if ( $new ) {
            $data[ 'new_product' ] = $new->toArray();
        }

        $sale = self::where( 'sale', '>', '0' )
                ->inRandomOrder()
                ->limit( 4 )
                ->with( 'category' )
                ->get();
        if ( $sale ) {
            $data[ 'sale_product' ] = $sale->toArray();
        }
        self::randomItems( $data );
    }

    public static function randomItems( &$data ) {
        $randomList = self::inRandomOrder()
                ->limit( 8 )
                ->with( 'category' )
                ->get();
        if ( $randomList ) {
            $data[ 'random_list_product' ] = $randomList->toArray();
        }
    }
    
    public static function getProducts( &$request, &$data ) {
        $data[ 'pagination' ][ 'url' ] = url( "dashboard/shop/product?page=" );

        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;

        if ( empty( $request[ 'find' ] ) ) {
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( self::count() / $limit );
            $data[ 'products' ] = self::offset( $offset )->limit( $limit )->get()->toArray();
        } else {
            $data[ 'products' ] = self::where( 'title', 'LIKE', "%{$request[ 'find' ]}%" );
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'products' ]->count() / $limit );
            $data[ 'products' ] = $data[ 'products' ]->offset( $offset )->limit( $limit )->get()->toArray();
        }
    }

}
