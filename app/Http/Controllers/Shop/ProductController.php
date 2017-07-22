<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Categorie;
use App\Models\Shop\Product;

class ProductController extends MainController {


    public function show( $cat,$product ) {
        Product::randomItems(self::$data);
        Product::getProduct($product, self::$data);
        return view( 'shop.product', self::$data );
    }

}
