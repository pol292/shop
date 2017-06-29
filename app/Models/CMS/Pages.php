<?php

namespace App\Models\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Pages extends Model {

    public static function getPages( &$data ) {
        $data[ 'cms_pages' ] = self::all()->toArray();
    }

    public static function getContents( $url, &$data, &$active ) {
        if ( $page = self::where( 'url', $url )->first() ) {
            $page = $page->toArray();
            if ( $active || $page[ 'active' ] ) {
                if ( $active )
                    $data[ 'back' ]     = $active;
                self::getTree( $page );
                $data[ 'contents' ] = [];
                self::sortChilds( $page, $data );
            }
        }

        if ( empty( $data[ 'contents' ] ) ) {
            abort( 404 );
        }
    }

    public static function getContentsById( $id, &$data ) {
        $root = self::find( $id )->toArray();
        self::getTree( $root );

        $data[ 'page_content' ][ 'id' ]      = &$root[ 'id' ];
        $data[ 'page_content' ][ 'url' ]     = &$root[ 'url' ];
        $data[ 'page_content' ][ 'title' ]   = &$root[ 'title' ];
        $data[ 'page_content' ][ 'article' ] = &$root[ 'article' ];
        $data[ 'page_content' ][ 'active' ]  = &$root[ 'active' ];
        $data[ 'page_content' ][ 'created_at' ]  = &$root[ 'created_at' ];
        $data[ 'page_content' ][ 'updated_at' ]  = &$root[ 'updated_at' ];

        $data[ 'page_json' ][ 'childs' ] = &$root[ 'childs' ];
        $data[ 'page_json' ]             = json_encode( $data[ 'page_json' ] );
    }

    private static function getTree( &$page ) {
        $contents    = self::find( $page[ 'id' ] )->page_contents->where( 'page_contents_id', NULL );
        $pageContent = [];

        foreach ( $contents as $content ) {
            $current                             = count( $pageContent );
            $pageContent[ $current ]             = $content->toArray();
            $pageContent[ $current ][ 'childs' ] = $content->childs->toArray();
        }
        $page             = $page;
        $page[ 'childs' ] = $pageContent;
    }

    private static function sortChilds( &$page, &$data, $c = 1 ) {
        if ( $c <= 6 ) {

            $current                                     = count( $data[ 'contents' ] );
            $data[ 'contents' ][ $current ][ 'tag' ]     = "h$c";
            $data[ 'contents' ][ $current ][ 'title' ]   = $page[ 'title' ];
            $data[ 'contents' ][ $current ][ 'article' ] = $page[ 'article' ];

            if ( count( $page[ 'childs' ] ) ) {
                foreach ( $page[ 'childs' ] as $child ) {
                    self::sortChilds( $child, $data, $c + 1 );
                }
            }
        }
    }

    public function page_contents() {
        return $this->hasMany( 'App\Models\CMS\Page_contents' )->orderBy( 'sort' );
    }

    public static function updatePage( &$request ) {
        $update = self::find( $request[ 'id' ] );

        $update[ 'title' ]   = $request[ 'title' ];
        $update[ 'url' ]     = $request[ 'url' ];
        $update[ 'article' ] = $request[ 'article' ];
        $update[ 'active' ]  = $request[ 'active' ] ? 1 : 0;

        if ( $update->save() ) {
            Session::flash( 'sm', "You are save successfull update (  {$request[ 'title' ]} ) page." );
        }
    }

    public static function addPage( &$request ) {

        $page = new self;

        $page[ 'title' ]   = $request[ 'title' ];
        $page[ 'url' ]     = $request[ 'url' ];
        $page[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';
        $page[ 'active' ]  = $request[ 'active' ] ? 1 : 0;

        if ( $page->save() ) {
            Session::flash( 'sm', "You are create successfull new (  {$request[ 'title' ]} ) page." );
            return redirect( url( "dashboard/CMS/page/{$page[ 'id' ]}/edit" ) );
        } else {
            Session::flash( 'wm', 'Can\'t add new page now please try after' );
            return redirect( url( "dashboard/CMS/page/" ) );
        }
    }

    public static function deletePage( &$id, &$request ) {

        DB::beginTransaction();
        try {

            $page    = self::find( $id );
            $content = Page_contents::where( 'pages_id', $id );
            $title   = $page[ 'title' ];
            if ( $page && $content ) {
                $page->delete();
                $content->delete();
                DB::commit();
                Session::flash( 'sm', "You are successfull delete page ($title)" );
            }else {
                
            }
        } catch ( \Exception $e ) {
            Session::flash( 'wm', 'Can\'t delete page now please try after' );
            DB::rollback();
        }
    }

}
