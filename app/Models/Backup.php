<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Pages;
use Session;

class Backup extends Model {

    private static $backup      = [];
    private static $backupTitle = '';

    /**
     * Set Backup
     * @param string $change The change 
     * @param string $type Where you change
     * @param string $description Info about change
     * @param array $data Data to save
     * @param string $icon fa icon name
     */
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
                if ( !empty( $backup[ 0 ][ 'id' ] ) && $find = $db->where( $type, $backup[ 0 ][ $type ] ) ) {
                    self::$backup[ $db->from ] = $find->get()->toArray();
                    foreach ( self::$backup[ $db->from ] as $key => $value ) {
                        self::$backup[ $db->from ][ $key ] = ( array ) $value;
                    }
                    $find->delete();
                }
                $db->insert( $backup );
            }
        }
    }

    public static function getBackup( &$type, &$data ) {
        $data[ 'type' ]     = $type;
        $data[ 'historys' ] = self::where( 'type', $type )->orderBy( 'updated_at', 'desc' )->get()->toArray();
    }

    public static function view( &$id, &$data ) {
        if ( $view = self::find( $id ) ) {
            $view           = $view->toArray();
            $data[ 'back' ] = $view[ 'type' ];
            $history        = unserialize( $view[ 'data' ] );
            if ( $history[ 'pages' ] ) {
                self::backupPage( $history, $data );
            }
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

        $old                 = explode( "\n", $data[ 'diff' ][ 'old' ] );
        $new                 = explode( "\n", $data[ 'diff' ][ 'new' ] );

        $diff                  = new \Diff( $old, $new, [] );
        $renderer              = new \Diff_Renderer_Html_Inline;
        $data[ 'differences' ] = $diff->Render( $renderer );
    }

}
