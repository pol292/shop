<?php

namespace App\Http\Controllers\Dashboard\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Shop\Product;
use Session;

//use App\Http\Requests\CategoryRequest;

class ManageProductController extends BaseDashboardController {

    public function __construct( Request $request ) {
        parent::__construct( $request );
        self::$data[ 'page' ] = 'Products Manager';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        Product::getProducts( $request, self::$data );
        if ( self::$data[ 'pagination' ][ 'count' ] !== 1 && empty( self::$data[ 'products' ] ) ) {
            if ( !empty( $request[ 'find' ] ) )
                Session::flash( 'wm', 'You are search for: "' . $request->find . '" you are get 0 resualts.' );
            return redirect( 'dashboard/shop/product?page=' . self::$data[ 'pagination' ][ 'count' ] );
        }
        return view( 'dashboard.shop.product.view_all', self::$data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'dashboard.shop.product.add', self::$data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        Categorie::addCategory( $request );
        return redirect( url( "dashboard/shop/product/" ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
//    public function show( Request $request, $url ) {
//        
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        Categorie::getContentsById( $id, self::$data );
        if ( !empty( self::$data[ 'category' ] ) ) {
            self::$data[ 'subtitle' ] = 'Edit: ' . self::$data[ 'product' ][ 'title' ];
            return view( 'dashboard.shop.product.edit', self::$data );
        } else {
            return redirect( url( 'dashboard/shop/product' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id ) {
        Categorie::deleteCategory( $id );
        return response()->json( ($request[ 'redirect' ] ? [ 'redirect' => 'dashboard/shop/product' ] : [] ) );
    }

}
