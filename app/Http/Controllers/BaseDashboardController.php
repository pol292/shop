<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseDashboardController extends Controller {

    protected static $data = [];

    public function __construct( Request $request ) {
        self::$data[ 'request' ] = $request;
        self::$data[ 'page' ] = '';
    }

}
