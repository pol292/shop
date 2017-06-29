<?php

namespace App\Http\Controllers\Dashboard\CMS;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\CMS\Page_contents;
use App\Http\Requests\ContentRequest;

class ManageContentController extends BaseDashboardController {

    public function updateSort( Request $request ) {
        Page_contents::updateContentSort( $request );
    }

    public function update( ContentRequest $request ) {
        Page_contents::updateContent( $request );
    }

    public function add( ContentRequest $request ) {
        Page_contents::addContent( $request );
        return redirect( $request->header( 'referer' ) );
    }

    public function delete( $id ) {
        Page_contents::deleteContent( $id );
        return response()->json([]);
    }

}
