<?php

namespace App\Http\Controllers;

use App\Models\CMS\Menu;
use Illuminate\Http\Request;

class MainController extends Controller {

    protected static $data = [];

    public function __construct(Request $request) {
        self::$data[ 'title' ]      = 'iDiver';
        self::$data[ 'page_url' ]   = '';
        self::$data[ 'breadcrumb' ] = [ [ 'title' => 'home', 'url' => url( '/' ) ] ];
        self::$data[ 'request' ]      = $request;
        Menu::getMenu( self::$data );
    }

    public static function setTitle( $title ) {
        self::$data[ 'title' ] = $title . ' - ' . self::$data[ 'title' ];
    }

}
