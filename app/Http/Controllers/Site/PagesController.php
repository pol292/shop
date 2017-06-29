<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\CMS\Pages;

class PagesController extends MainController {

    public function showPage( $url , $useActive = FALSE ) {
        Pages::getContents( $url ,self::$data ,$useActive);
        return view( 'cms.page', self::$data );
    }

    

}
