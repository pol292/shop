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

    public static function showCat( &$data, &$cat, &$request ) {
        $data[ 'range' ] = true;

        $limit  = empty( $request[ 'spg' ] ) ? 4 : $request[ 'spg' ];
        $offset = empty( $request[ 'page' ] ) ? 0 : ($request[ 'page' ] - 1) * $limit;

        if ( $cat == 'sale' ) {
            Product::getSale( $request, $data, $product );
        } elseif ( $cat == 'search' ) {
            Product::getSearch( $request, $data, $product );
        } else {
            $data[ 'cat' ] = self::where( 'url', $cat )->first();
            if ( $data[ 'cat' ] ) {
                $data[ 'cat' ] = $data[ 'cat' ]->toArray();
                $product       = Product::where( 'categorie_id', $data[ 'cat' ][ 'id' ] );
            }
        }

        $data[ 'rates' ] = [
            'minValue' => $product->min( 'price' ),
            'maxValue' => $product->max( 'price' )
        ];

        $data[ 'pagination' ] = [
            'active' => (empty( $request[ 'page' ] ) ? 1 : $request[ 'page' ]),
            'count'  => ( int ) ceil( $product->count() / $limit ),
            'url'    => url( 'shop/' . $cat . '?page=' ),
        ];


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
