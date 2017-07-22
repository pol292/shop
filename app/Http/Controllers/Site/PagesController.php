<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\CMS\Pages;
use App\Models\Shop\Categorie;
use App\Models\Shop\Product;

class PagesController extends MainController {

    public function showPage( $url, $useActive = FALSE ) {
        self::$data[ 'page_url' ] = $url;
        Pages::getContents( $url, self::$data, $useActive );
        if ( !empty( self::$data[ 'contents' ] ) ) {
            $title                                  = self::$data[ 'contents' ][ 0 ][ 'title' ];
            self::setTitle( $title );
            self::$data[ 'breadcrumb' ][ 'active' ] = $title;
            return view( 'cms.page', self::$data );
        } else {
            return self::show404();
        }
    }

    public function index() {
        self::$data[ 'page_url' ]   = 'index';
        self::$data[ 'categories' ] = Categorie::orderBy( 'title' )->get()->toArray();
        self::$data[ 'breadcrumb' ] = [ 'active' => 'home' ];
        Product::getIndexProducts( self::$data );
        return view( 'index', self::$data );
    }

    public function show404() {
        self::setTitle( 'Page not found' );
        return response()->view( 'errors.404', self::$data, 404 );
    }

}
