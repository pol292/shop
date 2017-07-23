<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\CMS\Pages;
use App\Models\Shop\Categorie;
use App\Models\Shop\Product;

class AjaxController extends MainController {

    public function getProductList( $url, $useActive = FALSE ) {
        Product::getProductList( $products );
        return response()->json( $products );
    }

    public function up( Request $request ) {
        if ( $request->hasFile( 'file' ) ) {
            //TODO: check if this image
            $file  = $request->file( 'file' );
            $image_name  = uniqid( date( 'd.m.Y_H-i-s_' ) ) . '_' . $file->getClientOriginalName();
//            $file->move( 'images/up', $image_name );
            return $image_name; 
//            $image = Image::make( sprintf( 'uploads/%s', $image_name ) )->resize( 200, 200 )->save();
        }
    }

}
