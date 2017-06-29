<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseDashboardController extends MainController
{
    protected static $data = [];
    public function __construct() {
        self::$data['page'] = '';
    }
    
}
