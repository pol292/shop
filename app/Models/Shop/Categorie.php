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

    public static function getCategories( &$request, &$data ) {
        $data[ 'pagination' ][ 'url' ] = url( "dashboard/shop/category?page=" );

        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;
        if ( empty( $request[ 'find' ] ) ) {
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( self::count() / $limit );
            $data[ 'categories' ]            = self::offset( $offset )->limit( $limit )->get()->toArray();
        } else {
            $data[ 'categories' ]            = self::where( 'title', 'LIKE', "%{$request[ 'find' ]}%" );
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'categories' ]->count() / $limit );
            $data[ 'categories' ]            = $data[ 'categories' ]->offset( $offset )->limit( $limit )->get()->toArray();
        }
    }

    public static function getContentsById( &$id, &$data ) {
        if ( $cat = self::find( $id ) ) {
            $data[ 'category' ] = $cat->toArray();
        }
    }

    public static function addCategory( &$request ) {
        DB::beginTransaction();
        try {

            $category = new self;

            $category[ 'title' ]   = $request[ 'title' ];
            $category[ 'url' ]     = $request[ 'url' ];
            $category[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';

            $category->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are create successfull new (  {$request[ 'title' ]} ) category." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t add new category now please try after' );
        }
    }

    public static function deleteCategory( $id ) {
        DB::beginTransaction();
        try {

            $category = self::find( $id );
            $title    = $category[ 'title' ];
            if ( $category ) {
//                self::pageBackup( 'delete', $category, 'trash-o' );
                $category->delete();

                DB::commit();
                Session::flash( 'sm', "You are successfull delete category ($title)" );
            } else {
                
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t delete category now please try after' );
        }
    }

    public static function updateCategory( &$request ) {
        DB::beginTransaction();
        try {

            $category = self::find($request['id']);

            $category[ 'title' ]   = $request[ 'title' ];
            $category[ 'url' ]     = $request[ 'url' ];
            $category[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';

            $category->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'title' ]} ) product." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t add update product now please try after' );
        }
    }

}
