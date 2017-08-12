<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Advertising;
use App\Http\Requests\AdvertisingRequest;

class ManageAdvertisingsController extends BaseDashboardController {

    public function __construct( Request $request ) {
        parent::__construct( $request );
        self::$data[ 'page' ] = 'Advertisings Manager';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        Advertising::getAdv( $request, self::$data );
        
        if ( self::$data[ 'pagination' ][ 'count' ] !== 0 && empty( self::$data[ 'advertisings' ] ) ) {
            if ( !empty( $request[ 'find' ] ) )
                Session::flash( 'wm', 'You are search for: "' . $request->find . '" you are get 0 resualts.' );
            return redirect( 'dashboard/advertisings?page=' . self::$data[ 'pagination' ][ 'count' ] );
        }
        return view( 'dashboard.advertising.view_all', self::$data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'dashboard.advertising.add', self::$data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdvertisingRequest $request ) {
        Advertising::addAdvertising( $request );
        return redirect( url( "dashboard/advertisings/" ) );
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
        Advertising::getContentsById( $id, self::$data );
        if ( !empty( self::$data[ 'adv' ] ) ) {
            self::$data[ 'subtitle' ] = 'Edit: ' . self::$data[ 'adv' ][ 'title' ];
            return view( 'dashboard.advertising.edit', self::$data );
        } else {
            return redirect( url( 'dashboard/advertising' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( AdvertisingRequest $request, $id ) {
        if ( $request[ 'id' ] == $id ) {
            Advertising::updateAdvertising( $request );
        }
        return redirect( $request->path() . '/edit' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id ) {
        Advertising::deleteAdvertising( $id );
        return response()->json( ($request[ 'redirect' ] ? [ 'redirect' => 'dashboard/advertisings' ] : [] ) );
    }

}
