<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product;
use App\Models\Backup;
use Session;

class Categorie extends Model {

    private static $limit;
    private static $offset;

    public function products() {
        return $this->hasMany( 'App\Models\Shop\Product' )->with( 'sale' );
    }

    private static function getProductsRate( $id, &$rates ) {
        $product = Product::where( 'categorie_id', $id );
        $rates   = [
            'minValue' => $product->min( 'price' ),
            'maxValue' => $product->max( 'price' )
        ];
    }

    public static function showCat( &$data, &$cat, &$request ) {
        $data[ 'range' ] = true;
        self::$limit     = empty($request[ 'spg' ])? 8 : $request[ 'spg' ];
        self::$offset    = empty( $request[ 'page' ] ) ? 0 : ($request[ 'page' ] - 1) * self::$limit;

        if ( $cat == 'sale' ) {
            if ( $product = Product::has( 'sale' )->with('sale')->offset( self::$offset )->limit( self::$limit )->get() ) {
                $product = $product->toArray();
            } else {
                $product = '';
            }
            $data[ 'cat' ] = [
                'title'    => 'Sale',
                'article'  => 'Sale Sale Sale',
                'url'      => 'sale',
                'products' => $product,
            ];
        } else {
            $data[ 'cat' ] = self::where( 'url', $cat )
                    ->with( 'products' )
                    ->first();
            if ( $data[ 'cat' ] ) {
                $data[ 'cat' ] = $data[ 'cat' ]->toArray();
                self::getProductsRate( $data[ 'cat' ][ 'id' ], $data[ 'rates' ] );
            }
        }
        $data[ 'breadcrumb' ][ 'active' ] = $data[ 'cat' ][ 'title' ];
    }

}
