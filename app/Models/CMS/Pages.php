<?php

namespace App\Models\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Pages extends Model {

    public static function getPages( $request, &$data ) {
        $data[ 'pagination' ][ 'url' ]   = url( "dashboard/CMS/page?page=" );
        
        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;

        $data[ 'cms_pages' ]             = self::all();
        $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'cms_pages' ]->count() / $limit );
        
        $data[ 'cms_pages' ] = self::offset( $offset )->limit( $limit )->get()->toArray();
    }

    public static function getContents( $url, &$data, &$active ) {
        if ( $page = self::where( 'url', $url )->first() ) {
            $page = $page->toArray();
            if ( $active || $page[ 'active' ] ) {
                if ( $active )
                    $data[ 'back' ] = $active;
                self::getTree( $page );
                self::sortChilds( $page, $data[ 'contents' ] );
            }
        }
    }

    public static function getContentsById( $id, &$data ) {
        if ( $root = self::find( $id ) ) {
            $root = $root->toArray();

            self::getTree( $root );

            $data[ 'page_content' ][ 'id' ]         = &$root[ 'id' ];
            $data[ 'page_content' ][ 'url' ]        = &$root[ 'url' ];
            $data[ 'page_content' ][ 'title' ]      = &$root[ 'title' ];
            $data[ 'page_content' ][ 'article' ]    = &$root[ 'article' ];
            $data[ 'page_content' ][ 'active' ]     = &$root[ 'active' ];
            $data[ 'page_content' ][ 'created_at' ] = &$root[ 'created_at' ];
            $data[ 'page_content' ][ 'updated_at' ] = &$root[ 'updated_at' ];

            $data[ 'page_json' ][ 'childs' ] = &$root[ 'childs' ];
            $data[ 'page_json' ]             = json_encode( $data[ 'page_json' ] );
        }
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
            $data[]  = [];
            $current = count( $data ) - 1;

            $data[ $current ][ 'tag' ]     = "h$c";
            $data[ $current ][ 'title' ]   = !empty( $page[ 'title' ] ) ? $page[ 'title' ] : '';
            $data[ $current ][ 'article' ] = !empty( $page[ 'article' ] ) ? $page[ 'article' ] : '';
            if ( !empty( $page[ 'childs' ] ) ) {
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
        DB::beginTransaction();
        try {

            $page = self::find( $request[ 'id' ] );

            self::pageBackup( 'update', $page, 'chevron-circle-up' );

            $page[ 'title' ]   = $request[ 'title' ];
            $page[ 'url' ]     = $request[ 'url' ];
            $page[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';
            $page[ 'active' ]  = $request[ 'active' ] ? 1 : 0;


            $page->save();
            DB::commit();

            Session::flash( 'sm', "You are save successfull update (  {$request[ 'title' ]} ) page." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t add new page now please try after' );
            return redirect( url( "dashboard/CMS/page/" ) );
        }
    }

    public static function addPage( &$request ) {
        DB::beginTransaction();
        try {

            $page = new self;

            $page[ 'title' ]   = $request[ 'title' ];
            $page[ 'url' ]     = $request[ 'url' ];
            $page[ 'article' ] = $request[ 'article' ] ? $request[ 'article' ] : '';
            $page[ 'active' ]  = $request[ 'active' ] ? 1 : 0;

            $page->save();
            DB::commit();
            $backup = [
                'pages' => [ 'id' => $page[ 'id' ] ],
            ];
            Backup::set( 'create', 'page', "Create page: {$page[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are create successfull new (  {$request[ 'title' ]} ) page." );
            return redirect( url( "dashboard/CMS/page/{$page[ 'id' ]}/edit" ) );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t add new page now please try after' );
            return redirect( url( "dashboard/CMS/page/" ) );
        }
    }

    public static function deletePage( &$id ) {

        DB::beginTransaction();
        try {

            $page    = self::find( $id );
            $content = Page_contents::where( 'pages_id', $id );
            $title   = $page[ 'title' ];
            if ( $page && $content ) {

                self::pageBackup( 'delete', $page, 'trash-o' );
                $page->delete();
                $content->delete();

                DB::commit();

                Session::flash( 'sm', "You are successfull delete page ($title)" );
            } else {
                
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t delete page now please try after' );
        }
    }

    public static function contentBackup( $change, $id, $icon = '' ) {
        $page = self::find( $id );
        self::pageBackup( $change, $page, $icon );
    }

    private static function pageBackup( $change, &$page, $icon = '' ) {
        $content = Page_contents::where( 'pages_id', $page[ 'id' ] )->orderBy( 'page_contents_id' )->orderBy( 'sort' );

        $backup = [
            'pages'         => $page->toArray(),
            'page_contents' => $content->get()->toArray(),
        ];
        Backup::set( $change, 'page', ucfirst( $change ) . " page: {$page[ 'title' ]}", $backup, $icon );
    }

    public static function previewHistory( &$history, &$data ) {
        $data[ 'diff' ][ 'old' ] = '';
        $data[ 'diff' ][ 'new' ] = '';
        if ( !empty( $history[ 'title' ] ) ) {
            self::sortChilds( $history, $data[ 'diff' ][ 'old' ] );
        }
        if ( !empty( $history[ 'id' ] ) && $new = self::find( $history[ 'id' ] ) ) {
            $new = $new->toArray();
            self::getTree( $new );
            self::sortChilds( $new, $data[ 'diff' ][ 'new' ] );
        }

        self::createHistoryHtml( $data );
    }

    public static function createHistoryHtml( &$data ) {
        $ret = [];
        if ( !empty( $data[ 'diff' ] ) ) {
            foreach ( $data[ 'diff' ] as $type => $version ) {
                if ( is_array( $version ) ) {
                    $ret[ $type ] = '';
                    foreach ( $version as $content ) {
                        $ret[ $type ] .= "<{$content[ 'tag' ]}>{$content[ 'title' ]}</{$content[ 'tag' ]}>\n";
                        $ret[ $type ] .= "<p>{$content[ 'article' ]}</p>\n";
                    }
                } else {
                    $ret[ $type ] = $version;
                }
            }
        }
        $data[ 'diff' ] = &$ret;
    }

}
