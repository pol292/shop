<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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
            if (self::$backup){
                self::set( 'restore', $restore[ 'type' ], "Restore: {$restore[ 'type' ]} {$restore[ 'change' ]}", self::$backup );
            }
            DB::commit();
            echo 'ok';
        } catch ( \Exception $e ) {
            DB::rollback();
            dd( $e );
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
    
    public static function getBackup(&$type ,&$data){
        $data['type'] = $type;
        $data['historys'] = self::where('type',$type)->orderBy('updated_at','desc')->get()->toArray();
    }

}
