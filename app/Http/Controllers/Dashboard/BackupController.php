<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Backup;

class BackupController extends BaseDashboardController {

    public function __construct() {
        self::$data[ 'page' ] = 'Restore';
    }

    public function restore( $id ) {
        Backup::restore( $id );
    }

    public function show( $type ) {
        self::$data[ 'page' ] .= " $type";
        Backup::getBackup( $type, self::$data );
        return view( 'dashboard.restore.view_all', self::$data );
    }

}
