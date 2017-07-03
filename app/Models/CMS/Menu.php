<?php

namespace App\Models\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use App\Models\CMS\Pages;
use Session;

class Menu extends Model {

    public static function getMenu( &$data ) {
        $data[ 'menu' ] = self::with( 'sub_menu' )->orderBy( 'sort' )->with( 'pages' )->where( 'menu_id', 0 )->get()->toArray();
        $menu           = self::get()->toArray();
        $pages_id       = [];
        foreach ( $menu as $m ) {
            $pages_id[] = $m[ 'page_id' ];
        }
        $data[ 'pages' ] = Pages::whereNotIn( 'id', $pages_id )->get()->toArray();
    }

    public function sub_menu() {
        return $this->hasMany( __CLASS__, 'menu_id', 'id' )->orderBy( 'sort' )->with( 'pages' );
    }

    public function pages() {
        return $this->hasOne( 'App\Models\CMS\Pages', 'id', 'page_id' );
    }

    public static function updateMenu( &$data ) {
        if ( !empty( $data[ 'data' ] ) ) {
            DB::beginTransaction();
            try {

                self::truncate();
                self::insert( $data[ 'data' ] );
                DB::commit();

                Session::flash( 'sm', "You are save successfull update site menu." );
            } catch ( \Exception $e ) {
                DB::rollback();
                Session::flash( 'wm', 'Can\'t update site menu now please try after' );
            }
        }
    }

}
