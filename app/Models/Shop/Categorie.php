<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product;
use App\Models\Backup;
use Session;

class Categorie extends Model {

    public function products() {
        return $this->hasMany( 'App\Models\Shop\Product' );
    }

    private static function getProductsRate( $id, &$rates ) {
        $product = Product::where( 'categorie_id', $id );
        $rates   = [
            'minValue' => $product->min( 'price' ),
            'maxValue' => $product->max( 'price' )
        ];
    }

    public static function showCat( &$data, &$cat ) {
        $data[ 'range' ] = true;
        if ( $cat == 'sale' ) {
            $data[ 'cat' ] = [
                'title' => 'Sale',
                'article' => 'Sale Sale Sale',
            ];
        } else {
            $data[ 'cat' ] = self::where( 'url', $cat )
                    ->with( 'products' )
                    ->first();
            if ( $data[ 'cat' ] ) {
                $data[ 'cat' ]   = $data[ 'cat' ]->toArray();

                self::getProductsRate( $data[ 'cat' ][ 'id' ], $data[ 'rates' ] );
                $data[ 'breadcrumb' ][ 'active' ] = $data[ 'cat' ][ 'title' ];
            }
        }
    }

}
