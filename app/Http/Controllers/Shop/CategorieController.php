<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Categorie;

class CategorieController extends MainController {

    public function show( $cat ) {
        self::$data[ 'range' ]                  = true;
        self::$data[ 'cat' ]                    = Categorie::where( 'url', $cat )->first()->toArray();
        $title                                = self::$data[ 'cat' ][ 'title' ];
        self::setTitle( $title );
        self::$data[ 'breadcrumb' ][ 'active' ] = $title;
        return view( 'shop.category', self::$data );
    }

}
