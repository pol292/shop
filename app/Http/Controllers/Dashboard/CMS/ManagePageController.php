<?php

namespace App\Http\Controllers\Dashboard\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\CMS\Pages;
use App\Http\Requests\PageRequest;

class ManagePageController extends BaseDashboardController {

    public function __construct() {
        self::$data[ 'page' ] = 'Page Manager';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Pages::getPages( self::$data );
        return view( 'dashboard.cms.page.page_view_all', self::$data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'dashboard.cms.page.page_add', self::$data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( PageRequest $request ) {
        return Pages::addPage( $request );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $url ) {
        return (new \App\Http\Controllers\Site\PagesController() )->showPage( $url, $request->header( 'referer' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        Pages::getContentsById( $id, self::$data );
        self::$data[ 'subtitle' ] = 'Edit: ' . self::$data[ 'page_content' ][ 'title' ];
        return view( 'dashboard.cms.page.page_edit', self::$data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( PageRequest $request, $id ) {
        if ( $request[ 'id' ] == $id ) {
            Pages::updatePage( $request );
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
        Pages::deletePage( $id, $request );
        return response()->json( ($request[ 'redirect' ] ? [ 'redirect' => 'dashboard/CMS/page' ] : [] ) );
    }

}
