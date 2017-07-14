<?php

namespace App\Http\Controllers;

use App\Models\CMS\Menu;
use Illuminate\Http\Request;

class MainController extends Controller {

    protected static $data = [];

    public function __construct() {
        self::$data[ 'title' ]      = 'iDiver';
        self::$data[ 'page_url' ]   = '';
        self::$data[ 'breadcrumb' ] = [ [ 'title' => 'home', 'url' => url( '/' ) ] ];
        Menu::getMenu( self::$data );
    }

    public static function setTitle( $title ) {
        self::$data[ 'title' ] = $title . ' - ' . self::$data[ 'title' ];
    }

}
