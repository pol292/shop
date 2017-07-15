<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Categorie;

class CategorieController extends MainController {

    public function show( Request $request, $cat ) {
        dd(old('sort'));
        Categorie::showCat( self::$data, $cat, $request );
        self::setTitle( self::$data[ 'cat' ][ 'title' ] );
        return view( 'shop.category', self::$data );
    }

}
