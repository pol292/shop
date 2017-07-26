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
        self::setTitle(self::$data['product']['title'] . ' - ' . self::$data['breadcrumb'][1]['title']);
        return view( 'shop.product', self::$data );
    }

}
