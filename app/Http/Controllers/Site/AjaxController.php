<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\CMS\Pages;
use App\Models\Shop\Categorie;
use App\Models\Shop\Product;

class AjaxController extends MainController {

    public function getProductList( $url, $useActive = FALSE ) {
        Product::getProductList($products);
        return response()->json($products);
    }

}
