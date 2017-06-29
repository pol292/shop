<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\CMS\Pages;

class DashboardController extends BaseDashboardController {

    function index() {
        self::$data['page'] = 'Dashboard';
        return view('dashboard.main',self::$data );
    }

}
