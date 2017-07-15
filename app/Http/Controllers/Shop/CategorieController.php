<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Categorie;

class CategorieController extends MainController {

    public function show( $cat ) {
        Categorie::showCat(self::$data,$cat);     
        self::setTitle(self::$data[ 'cat' ][ 'title' ]);
        
        return view( 'shop.category', self::$data );
    }

}
