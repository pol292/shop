<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Pages;
use Session;

class Backup extends Model {

    private static $backup = [];

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
            $restore = self::find( $id )->toArray();
            switch ( $restore[ 'change' ] ) {
                case 'delete':
                case 'update':
                case 'restore':
                    self::restoreCheck( $restore );
                    break;
                case 'create':
                    self::unCreate( $restore );
                    break;
            }
            if ( self::$backup ) {
                self::set( 'restore', $restore[ 'type' ], "Restore: {$restore[ 'type' ]} {$restore[ 'change' ]}", self::$backup );
            }
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollback();
        }
    }

    private static function restoreCheck( &$restore ) {
        $data = unserialize( $restore[ 'data' ] );
        foreach ( $data as $table => $backup ) {
            if ( !empty( $backup[ 'id' ] ) ) {
                self::restoreProcess( $table, $backup );
            } elseif ( is_array( $backup ) ) {
                foreach ( $backup as $arr ) {
                    self::restoreProcess( $table, $arr );
                }
            }
        }
    }

    private static function restoreProcess( &$table, &$backup ) {
        $backup = ( array ) $backup;
        $db     = DB::table( $table );
        self::dataToBackup( $db, $backup[ 'id' ] );
        $db->insert( $backup );
    }

    private static function unCreate( &$restore ) {
        $data = unserialize( $restore[ 'data' ] );
        $db   = DB::table( $data[ 'table' ] );
        self::dataToBackup( $db, $data[ 'id' ] );
    }

    private static function dataToBackup( &$db, &$id ) {
        if ( $find = $db->where( 'id', $id ) ) {
            self::$backup[ $db->from ][] = ( array ) $find->first();
            $find->delete();
        }
    }

    public static function getBackup( &$type, &$data ) {
        $data[ 'type' ]     = $type;
        $data[ 'historys' ] = self::where( 'type', $type )->orderBy( 'updated_at', 'desc' )->get()->toArray();
    }

    public static function view( &$id, &$data ) {
        $view    = self::find( $id )->toArray();
        $history = unserialize( $view[ 'data' ] );
        $sort    = [];
        if ( !empty( $history[ 'page_contents' ] ) ) {
            foreach ( $history[ 'page_contents' ] as $arr ) {
                $sort[ $arr[ 'id' ] ]             = $arr;
                $sort[ $arr[ 'id' ] ][ 'childs' ] = [];
            }
            foreach ( $sort as $key => $arr ) {
                if ( $arr[ 'page_contents_id' ] ) {
                    $sort[ $arr[ 'page_contents_id' ] ][ 'childs' ][] = $arr;
                    unset( $sort[ $key ] );
                }
            }
            $history             = &$history[ 'pages' ];
            $history[ 'childs' ] = &$sort;
        } else {
            $history[ 'no_old' ] = "";
        }
        if ( empty( $history[ 'id' ] ) ) {
            if ( isset( $history[ 'no_old' ] ) ) {
                unset( $history[ 'no_old' ] );
                sort( $history );
                $history[ 0 ][ 0 ][ 'no_old' ] = "";
            }
            $history = $history[ 0 ][ 0 ];
        }

        if ( !empty( $history[ 'id' ] ) )
            Pages::previewHistory( $history, $data );
        self::createPageHtml( $data );
        $old = !empty( $data[ 'diff' ][ 'old' ] ) ? $data[ 'diff' ][ 'old' ] : '';
        $new = !empty( $data[ 'diff' ][ 'new' ] ) ? $data[ 'diff' ][ 'new' ] : '';

        $old            = explode( "\n", $old );
        $new            = explode( "\n", $new );
        $diff           = new \Diff( $old, $new, [] );
        $renderer       = new \Diff_Renderer_Html_SideBySide;
        $data[ 'diff' ] = $diff->Render( $renderer );
    }

    public static function createPageHtml( &$data ) {
        $ret = [];
        if ( !empty( $data['diff'] ) ) {
            foreach ( $data[ 'diff' ] as $type => $version ) {
                if ( is_array( $version ) ) {
                    $ret[ $type ] = '';
                    foreach ( $version as $content ) {
                        $ret[ $type ] .= "<{$content[ 'tag' ]}>{$content[ 'title' ]}</{$content[ 'tag' ]}>\n";
                        $ret[ $type ] .= "<p>{$content[ 'article' ]}</p>\n";
                    }
                    $ret[ $type ] .= "</div>";
                } else {
                    $ret[ $type ] = $version;
                }
            }
        }
        $data[ 'diff' ] = &$ret;
    }

}
