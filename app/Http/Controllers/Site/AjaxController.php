<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Product;
use Illuminate\Support\Facades\Validator;

class AjaxController extends MainController {

    public function getProductList( $url, $useActive = FALSE ) {
        Product::getProductList( $products );
        return response()->json( $products );
    }

    public function up( Request $request ) {
        if ( $request->hasFile( 'file' ) ) {
            $file = $request->file;
            if ( $file->isValid() ) {
                $validator = Validator::make( $request->all(), [
                            'file' => 'required|image',
                        ] );
                if ( !$validator->fails() ) {
                    $image_name = uniqid( date( 'd.m.Y_H-i-s_' ) ) . '_' . $file->getClientOriginalName();
                    //todo: add woter mark and resize
                    $file->move( 'images/up', $image_name );
                    return $image_name;
                }
            }
        }
    }

}
