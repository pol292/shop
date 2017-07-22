<?php

namespace App\Http\Controllers\Dashboard\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Shop\Categorie;
use App\Http\Requests\CategoryRequest;

class ManageCategoriesController extends BaseDashboardController {

    public function __construct( Request $request ) {
        parent::__construct( $request );
        self::$data[ 'page' ] = 'Categories Manager';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        Categorie::getCategories( $request, self::$data );
        if ( empty( self::$data[ 'categories' ] ) ) {
            return redirect( 'dashboard/shop/category?page=' . self::$data[ 'pagination' ][ 'count' ] );
        }
        return view( 'dashboard.shop.category.view_all', self::$data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'dashboard.shop.category.add', self::$data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( CategoryRequest $request ) {
        Categorie::addCategory( $request );
        return redirect( url( "dashboard/shop/category/" ) );
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
            self::$data[ 'subtitle' ] = 'Edit: ' . self::$data[ 'category' ][ 'title' ];
            return view( 'dashboard.shop.category.edit', self::$data );
        } else {
            return redirect( url( 'dashboard/shop/category' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( CategoryRequest $request, $id ) {
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
        return response()->json( ($request[ 'redirect' ] ? [ 'redirect' => 'dashboard/shop/category' ] : [] ) );
    }

}
