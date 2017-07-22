<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Backup;

class BackupController extends BaseDashboardController {

    public function __construct(Request $request) {
        parent::__construct($request);
        self::$data[ 'page' ] = 'Recovery';
    }

    public function restore( Request $request, $id ) {
        Backup::restore( $id );
        return redirect( url( "dashboard/restore/view/$id" ) );
    }

    public function view( Request $request, $id ) {
        self::$data[ 'id' ] = $id;
        Backup::view( $id, self::$data );
        return view( 'dashboard.restore.diff', self::$data );
    }

    public function history( Request $request, $type ) {
        self::$data[ 'page' ] .= " $type";
        Backup::getBackup( $request, $type, self::$data );
        return view( 'dashboard.restore.view', self::$data );
    }

}
