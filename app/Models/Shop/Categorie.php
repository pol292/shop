<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product;
use App\Models\Backup;
use Session;

class Categorie extends Model {

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

        $limit  = empty( $request[ 'spg' ] ) ? 8 : $request[ 'spg' ];
        $offset = empty( $request[ 'page' ] ) ? 0 : ($request[ 'page' ] - 1) * $limit;

        if ( $cat == 'sale' ) {
            $product = Product::has( 'sale' );

            $data[ 'cat' ]   = [
                'title'   => 'Sale',
                'article' => 'Sale Sale Sale',
                'url'     => 'sale',
            ];
            $data[ 'rates' ] = [
                'minValue' => Product::has( 'sale' )->min( 'price' ),
                'maxValue' => Product::has( 'sale' )->max( 'price' ),
            ];
            $product         = $product->with( 'sale' );
        } else {
            $data[ 'cat' ] = self::where( 'url', $cat )->first();
            if ( $data[ 'cat' ] ) {
                $data[ 'cat' ] = $data[ 'cat' ]->toArray();
                $product       = Product::where( 'categorie_id', $data[ 'cat' ][ 'id' ] );
            }
            self::getProductsRate( $data[ 'cat' ][ 'id' ], $data[ 'rates' ] );
        }


        $min = $request[ 'min-price' ];
        $max = $request[ 'max-price' ];

        if ( empty( $min ) && !is_numeric( $min ) ) {
            $min = $data[ 'rates' ][ 'minValue' ];
        }
        if ( empty( $max ) && !is_numeric( $max ) ) {
            $max = $data[ 'rates' ][ 'maxValue' ];
        }
        $product = $product->whereBetween( 'price', [ $min, $max ] )
                ->offset( $offset )
                ->limit( $limit );

        if ( !empty( $request[ 'sort' ] ) && $request[ 'sort' ] == 'lth' ) {
            $product = $product->orderBy( 'price' );
        } elseif ( !empty( $request[ 'sort' ] ) && $request[ 'sort' ] == 'htl' ) {
            $product = $product->orderBy( 'price', 'desc' );
        }

        $product = $product->get();


        $data[ 'cat' ][ 'products' ]      = ($product) ? $product->toArray() : '';
        $data[ 'breadcrumb' ][ 'active' ] = $data[ 'cat' ][ 'title' ];
    }

}
