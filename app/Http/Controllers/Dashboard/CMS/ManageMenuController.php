<?php

namespace App\Http\Controllers\Dashboard\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\CMS\Menu;

class ManageMenuController extends BaseDashboardController {

    public function __construct() {
        self::$data[ 'page' ] = 'Menu Manager';
    }

    public function edit() {
        Menu::getMenuEdit(self::$data );
        return view( 'dashboard.cms.menu.edit', self::$data );
    }
    
    public function update(Request $request){
        Menu::updateMenu($request);
    }
    
}
