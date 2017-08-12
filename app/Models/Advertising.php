<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Advertising extends Model {

    public static function get( &$data ) {
        if ( $adv = self::inRandomOrder( )->limit(5)->get() ) {
            $data[ 'advs' ] = $adv->toArray();
        }
    }

    public static function getAdv( &$request, &$data ) {
        $data[ 'pagination' ][ 'url' ] = url( "dashboard/advertisings?page=" );

        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;
        if ( empty( $request[ 'find' ] ) ) {
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( self::count() / $limit );
            $data[ 'advertisings' ]          = self::offset( $offset )->limit( $limit )->get()->toArray();
        } else {
            $data[ 'advertisings' ]          = self::where( 'title', 'LIKE', "%{$request[ 'find' ]}%" );
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'advertisings' ]->count() / $limit );
            $data[ 'advertisings' ]          = $data[ 'advertisings' ]->offset( $offset )->limit( $limit )->get()->toArray();
        }
    }

    public static function getContentsById( &$id, &$data ) {
        if ( $adv = self::find( $id ) ) {
            $data[ 'adv' ] = $adv->toArray();
        }
    }

    public static function updateAdvertising( &$request ) {
        DB::beginTransaction();
        try {

            $adv = self::find( $request[ 'id' ] );

            $adv[ 'title' ]   = $request[ 'title' ];
            $adv[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';
            $adv[ 'url' ]     = $request[ 'url' ];
            $adv[ 'image' ]   = $request[ 'image' ];

            $adv->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'title' ]} ) advertising." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update advertising now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    public static function addAdvertising( &$request ) {
        DB::beginTransaction();
        try {

            $adv = new self;

            $adv[ 'title' ]   = $request[ 'title' ];
            $adv[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';
            $adv[ 'url' ]     = $request[ 'url' ];
            $adv[ 'image' ]   = $request[ 'image' ];

            $adv->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'title' ]} ) advertising." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update advertising now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }
    
    public static function deleteAdvertising( $id ) {
        DB::beginTransaction();
        try {

            $adv = self::find( $id );
            $title    = $adv[ 'title' ];
            if ( $adv ) {
//                self::pageBackup( 'delete', $category, 'trash-o' );
                $adv->delete();

                DB::commit();
                Session::flash( 'sm', "You are successfull delete advertising ($title)" );
            } else {
                
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t delete advertising now please try after' );
        }
    }

}
