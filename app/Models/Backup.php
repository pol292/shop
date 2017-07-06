<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Pages;
use App\Models\CMS\Menu;
use Session;

class Backup extends Model {

    private static $backup      = [];
    private static $backupTitle = '';

    public static function set( $change, $type, $description, &$data, $icon = '' ) {
        $backup = new self();

        $backup[ 'change' ]      = $change;
        $backup[ 'type' ]        = $type;
        $backup[ 'description' ] = $description;
        $backup[ 'data' ]        = serialize( $data );
        $backup[ 'icon' ]        = $icon;

        $backup->save();
    }

    public static function restore( $id ) {
        DB::beginTransaction();
        try {
            if ( $restore = self::find( $id ) ) {
                $restore = $restore->toArray();
                if ( $restore[ 'type' ] == 'menu' ) {
                    Menu::restore( $restore );
                }
                if ( $restore[ 'type' ] == 'page' ) {
                    self::restoreCheck( $restore, $restore[ 'type' ] . 's_id' );

                    if ( self::$backup ) {
                        switch ( $restore[ 'change' ] ) {
                            case 'create':
                            case 'restore: create':
                                $des = 'delete';
                                break;
                            case 'delete':
                            case 'restore: delete':
                                $des = 'create';
                                break;
                            default:
                                $des = 'update';
                        }
                        self::set( 'restore: ' . $des, $restore[ 'type' ], "Restore $des: " . self::$backupTitle . " {$restore[ 'type' ]}", self::$backup, 'history' );
                    }
                }
                DB::commit();
                Session::flash( 'sm', "You are successfull resotre {$restore[ 'change' ]}." );
            } else {
                //Todo: error
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', "Can't restore {$restore[ 'change' ]} now please try after." );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    private static function restoreCheck( &$restore, $type ) {
        $data = unserialize( $restore[ 'data' ] );
        foreach ( $data as $table => $backup ) {
            $db = DB::table( $table );
            if ( !empty( $backup[ 'id' ] ) ) {
                if ( $find = $db->where( 'id', $backup[ 'id' ] ) ) {
                    $data = ( array ) $find->first();
                    if ( !empty( $data ) ) {
                        self::$backup[ $db->from ] = $data;
                        if ( !empty( $data[ 'title' ] ) )
                            self::$backupTitle         = $data[ 'title' ];
                        $find->delete();
                    } else if ( !empty( $backup ) ) {
                        self::$backup[ $db->from ] = [ 'id' => $backup[ 'id' ] ];
                        if ( !empty( $backup[ 'title' ] ) )
                            self::$backupTitle         = $backup[ 'title' ];
                    }
                } elseif ( !empty( $backup[ 'id' ] ) ) {
                    self::$backup[ $table ] = [ 'id' => $backup[ 'id' ] ];
                }
                if ( count( $backup ) > 1 ) {
                    $db->insert( $backup );
                }
            } elseif ( is_array( $backup ) ) {
                
            } elseif ( !empty( $backup[ 0 ][ 'id' ] ) && $find = $db->where( $type, $backup[ 0 ][ $type ] ) ) {
                self::$backup[ $db->from ] = $find->get()->toArray();
                foreach ( self::$backup[ $db->from ] as $key => $value ) {
                    self::$backup[ $db->from ][ $key ] = ( array ) $value;
                }
                $find->delete();
            }
            $db->insert( $backup );
        }
    }

    public static function getBackup( &$request, &$type, &$data ) {
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $data[ 'type' ]                   = $type;
        $limit                            = 5;
        $offset                           = $limit * $page;

        $data[ 'historys' ] = self::orderBy( 'updated_at', 'desc' );

        if ( $type != 'all' ) {
            $data[ 'historys' ]              = $data[ 'historys' ]->where( 'type', $type );
            $data[ 'pagination' ][ 'count' ] = $data[ 'historys' ] ->where( 'type', $type );
        }
        $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'historys' ]->count() / $limit );
        $data[ 'historys' ]              = $data[ 'historys' ]->offset( $offset )->limit( $limit )->get();

        $data[ 'pagination' ][ 'url' ] = url("dashboard/restore/history/$type?page=");
        $data[ 'historys' ] = $data[ 'historys' ]->toArray();
    }

    public static function view( &$id, &$data ) {
        $data[ 'back' ] = 'all';
        if ( $view           = self::find( $id ) ) {
            $view               = $view->toArray();
            $data[ 'subtitle' ] = $view[ 'description' ];
            $data[ 'back' ]     = $view[ 'type' ];
            $history            = unserialize( $view[ 'data' ] );
            if ( isset( $history[ 'pages' ] ) ) {
                self::backupPage( $history, $data );
            } elseif ( isset( $history[ 'menu' ] ) ) {
                Menu::previewHistory( $history, $data );
            }

            $old = explode( "\n", $data[ 'diff' ][ 'old' ] );
            $new = explode( "\n", $data[ 'diff' ][ 'new' ] );

            $diff                  = new \Diff( $old, $new, [] );
            $renderer              = new \Diff_Renderer_Html_Inline;
            $data[ 'differences' ] = $diff->Render( $renderer );
        }
    }

    private static function backupPage( &$history, &$data ) {
        $sort = [];
        if ( !empty( $history[ 'page_contents' ] ) ) {
            foreach ( $history[ 'page_contents' ] as $arr ) {
                $arr                              = ( array ) $arr;
                $sort[ $arr[ 'id' ] ]             = $arr;
                $sort[ $arr[ 'id' ] ][ 'childs' ] = [];
            }
            foreach ( $sort as $key => $value ) {
                if ( $value[ 'page_contents_id' ] ) {
                    $sort[ $value[ 'page_contents_id' ] ][ 'childs' ][] = &$sort[ $value[ 'id' ] ];
                    unset( $sort[ $key ] );
                }
            }
        }
        $history             = &$history[ 'pages' ];
        $history[ 'childs' ] = &$sort;
        Pages::previewHistory( $history, $data );
    }

}
