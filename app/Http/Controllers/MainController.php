<?php

namespace App\Http\Controllers;

use App\Models\CMS\Menu;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected static $data = [];
    public function __construct() {
        Menu::getMenu(self::$data);
    }
}
