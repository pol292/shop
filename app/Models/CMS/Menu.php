<?php

namespace App\Models\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use App\Models\CMS\Pages;
use Session;

class Menu extends Model {

    public static function getMenu( &$data ) {
        $data[ 'menu' ] = self::with( 'sub_menu' )
                ->orderBy( 'sort' )
                ->with( 'pages' )
                ->where( 'menu_id', 0 )
                ->get()
                ->toArray();

        foreach ( $data[ 'menu' ] as $key => $menu ) {
            if ( !$menu[ 'pages' ][ 'active' ] ) {
                unset( $data[ 'menu' ][ $key ] );
            }

            if ( !empty( $menu[ 'sub_menu' ] ) )
                foreach ( $menu[ 'sub_menu' ] as $sub_key => $sub_menu ) {
                    if ( !$sub_menu[ 'pages' ][ 'active' ] ) {
                        unset( $data[ 'menu' ][ $key ][ 'sub_menu' ][ $sub_key ] );
                    }
                }
        }
    }

    public static function getMenuEdit( &$data ) {
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

    public static function updateMenu( &$data, $backup = TRUE ) {
        if ( !empty( $data[ 'data' ] ) || !$backup) {
            DB::beginTransaction();
            try {
                if ( $backup )
                    self::backup();
                self::truncate();
                self::insert( $data[ 'data' ] );
                DB::commit();

                Session::flash( 'sm', "You are save successfull update site menu." );
            } catch ( \Exception $e ) {
                DB::rollback();
                Session::flash( 'wm', 'Can\'t update site menu now please try after' );
                Session::flash( 'wm', $e->getMessage() );
            }
        }
    }

    private static function backup( $type = 'update', $icon = 'chevron-circle-up' ) {
        $backup = [
            'menu' => self::orderBy( 'menu_id' )->orderBy( 'sort' )->get()->toArray(),
        ];

        Backup::set( $type, 'menu', ucfirst( $type ) . " menu", $backup, $icon );
    }

    private static function sortHistoryMenu( &$history, &$data ) {
        $sort = [];
        if ( !empty( $history[ 'menu' ] ) ) {
            foreach ( $history[ 'menu' ] as $value ) {
                if ( $value[ 'menu_id' ] && isset( $sort[ $value[ 'menu_id' ] ] ) ) {
                    $sort[ $value[ 'menu_id' ] ][ 'sub_menu' ][] = Pages::find( $value[ 'id' ] )->toArray();
                } else {
                    $sort[ $value[ 'id' ] ] = Pages::find( $value[ 'id' ] )->toArray();
                }
            }
            foreach ( $sort as $menu ) {
                $data .= "<li>\n<a href='{$menu[ 'url' ]}'>{$menu[ 'title' ]}</a>\n";
                if ( !empty( $menu[ 'sub_menu' ] ) ) {
                    $data .= "<ol>\n";
                    foreach ( $menu[ 'sub_menu' ] as $sub_menu ) {
                        $data .= "<li>\n<a href='{$sub_menu[ 'url' ]}'>{$sub_menu[ 'title' ]}</a>\n</li>";
                    }
                    $data .= "</ol>\n";
                }
                $data .= "</li>\n";
            }
        }
    }

    public static function previewHistory( &$history, &$data ) {
        $data[ 'diff' ][ 'old' ] = '';
        $data[ 'diff' ][ 'new' ] = '';
        self::sortHistoryMenu( $history, $data[ 'diff' ][ 'old' ] );
        $new[ 'menu' ]           = self::orderBy( 'menu_id' )->orderBy( 'sort' )->get()->toArray();
        self::sortHistoryMenu( $new, $data[ 'diff' ][ 'new' ] );
    }

    public static function restore( &$restore ) {
        self::backup( 'restore: update', 'history' );
        $menu[ 'data' ] = unserialize( $restore[ 'data' ] )[ 'menu' ];
        self::updateMenu( $menu , FALSE );
    }

}
