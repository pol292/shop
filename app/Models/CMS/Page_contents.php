<?php

namespace App\Models\CMS;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Page_contents extends Model {

    private function getChilds() {
        return $this->hasMany( 'App\Models\CMS\Page_contents', 'page_contents_id', 'id' )->orderBy( 'sort' );
    }

    public function childs() {
        return $this->getChilds()->with( 'childs' );
    }

    public static function updateContentSort( &$request ) {
        if ( $request[ 'data' ] ) {
            DB::beginTransaction();
            try {
                foreach ( $request[ 'data' ] as $id => $sort ) {
                    $valid = isset( $id ) &&
                            is_numeric( $id ) &&
                            isset( $sort[ 'page_contents_id' ] ) &&
                            is_numeric( $sort[ 'page_contents_id' ] ) &&
                            isset( $sort[ 'page_contents_id' ] ) &&
                            is_numeric( $sort[ 'page_contents_id' ] );

                    if ( $valid && $content = self::find( $id ) ) {

                        $content[ 'page_contents_id' ] = $sort[ 'page_contents_id' ];
                        $content[ 'sort' ]             = $sort[ 'sort' ];

                        $content->save();
                    }
                }

                Pages::contentBackup( 'update', $content->toArray()[ 'pages_id' ], 'chevron-circle-up' );
                DB::commit();
                Session::flash( 'sm', "You are save successfull update sort of page" );
            } catch ( \Exception $e ) {
                DB::rollback();
                Session::flash( 'wm', 'Can\'t  update page now please try after' );
            }
        }
    }

    public static function updateContent( &$request ) {
        $valid = $request &&
                !empty( $request[ 'id' ] ) &&
                !empty( $request[ 'content-title' ] ) &&
                !empty( $request[ 'article' ] );
        DB::beginTransaction();
        try {
            if ( $valid && $content = self::find( $request[ 'id' ] ) ) {
                $content[ 'title' ]   = $request[ 'content-title' ];
                $content[ 'article' ] = $request[ 'article' ];

                $content->save();
                DB::commit();
                Pages::contentBackup( 'update', $content[ 'pages_id' ], 'chevron-circle-up' );

                Session::flash( 'sm', "You are save successfull update (  {$request[ 'content-title' ]} ) content." );
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t  update page now please try after' );
        }
    }

    public static function addContent( &$request ) {
        DB::beginTransaction();
        try {
            $max                       = self::where( 'pages_id', $request[ 'id' ] )->where( 'page_contents_id', '0' )->max( 'sort' );
            $content                   = new self;
            $content->pages_id         = $request[ 'id' ];
            $content->page_contents_id = 0;
            $content->sort             = $max + 1;
            $content->title            = $request[ 'content-title' ];
            $content->article          = $request[ 'content-article' ] ? $request[ 'content-article' ] : '';

            $content->save();
            Pages::contentBackup( 'update', $request[ 'id' ], 'chevron-circle-up' );

            DB::commit();
            Session::flash( 'sm', "You are successfull added new content ({$request[ 'content-title' ]})" );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t  update page now please try after' );
        }
    }

    public static function deleteContent( &$id ) {
        DB::beginTransaction();
        try {
            $content = self::find( $id );
            $title   = $content[ 'title' ];
            Pages::contentBackup( 'update', $content[ 'pages_id' ], 'chevron-circle-up' );
            $content->delete();
            DB::commit();
            Session::flash( 'sm', "You are successfull delete content ($title)" );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t  update page now please try after' );
        }
    }

}
