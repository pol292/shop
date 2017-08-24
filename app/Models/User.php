<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Session;

class User extends Model {

    public static function register( &$request ) {
        if ( !(self::where( 'email', $request[ 'email' ] )->first()) ) {
            $user           = new self;
            $user->email    = $request[ 'email' ];
            $user->password = Hash::make( $request[ 'password' ] );
            $user->name     = $request[ 'name' ];
            $user->role     = 1;
            $user->facebook = !empty( $request[ 'facebook' ] ) ? $request[ 'facebook' ] : false;
            $user->save();

            Session::put( [ 'user' => $user ] );

            Session::flash( 'sm', 'Hello ' . $user->name . ', you are successfull register.' );
        }
    }

    public static function login( &$request ) {
        if ( $user = self::where( 'email', $request[ 'email' ] )->first() ) {

            $session_user = Session::get( 'user' );
            if ( !empty( $session_user ) ) {
                $check = $user->email == $session_user[ 'email' ] &&
                        $session_user[ 'password' ] == $user->password;
            } else {
                $check = $user->email == $request[ 'email' ] &&
                        Hash::check( $request[ 'password' ], $user->password );
            }
            if ( $check ) {
                Session::put( [ 'user' => $user ] );
                if ( empty( $session_user ) ) {
                    $request->redirect = !empty( $request->redirect ) ? $request->redirect : '/';
                } else {
                    $request = $user;
                }
                $request->login = TRUE;
            } else {
                Session::forget( 'user' );
                if ( empty( $session_user ) ) {
                    Session::flash( 'wm', 'Worng email or password please try again.' );
                    $request->redirect = 'user/login';
                }
                $request->login = FALSE;
            }
        }
    }

    public static function logout() {
        Session::forget( 'user' );
    }

    public static function facebookLogin( &$data, $url = 'user/facebook' ) {
        $fb = new \Facebook\Facebook( [
            'app_id'                => '1969953169955602',
            'app_secret'            => '679d3d5350af5eec5b7d4753e3b5ad09',
            'default_graph_version' => 'v2.10',
                ] );


        $helper = $fb->getRedirectLoginHelper();

        $data[ 'facebook' ] = $helper->getLoginUrl( url( $url ), [ 'email' ] );
    }

    public static function facebookAuth( &$data ) {
        $fb     = new \Facebook\Facebook( [
            'app_id'                => '1969953169955602',
            'app_secret'            => '679d3d5350af5eec5b7d4753e3b5ad09',
            'default_graph_version' => 'v2.10',
                ] );
        $helper = $fb->getRedirectLoginHelper();
        if ( isset( $_GET[ 'state' ] ) ) {
            $helper->getPersistentDataHandler()->set( 'state', $_GET[ 'state' ] );
        }
        try {
            $accessToken = $helper->getAccessToken();
            $response    = $fb->get( '/me?fields=name,email', $accessToken );
        } catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
            return;
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
            return;
        }

        $user = $response->getGraphUser();
        if ( !empty( $user[ 'id' ] ) ) {
            if ( $log = self::where( 'facebook', $user[ 'id' ] )->first() ) {
                Session::put( [ 'user' => $log ] );
            } else {
                $data[ 'facebook' ] = [
                    'id'    => $user[ 'id' ],
                    'name'  => empty( $user[ 'name' ] ) ? '' : $user[ 'name' ],
                    'email' => empty( $user[ 'email' ] ) ? '' : $user[ 'email' ],
                ];
            }
        }
    }

    public static function facebookAuthLink() {
        $fb     = new \Facebook\Facebook( [
            'app_id'                => '1969953169955602',
            'app_secret'            => '679d3d5350af5eec5b7d4753e3b5ad09',
            'default_graph_version' => 'v2.10',
                ] );
        $helper = $fb->getRedirectLoginHelper();
        if ( isset( $_GET[ 'state' ] ) ) {
            $helper->getPersistentDataHandler()->set( 'state', $_GET[ 'state' ] );
        }
        try {
            $accessToken = $helper->getAccessToken();
            $response    = $fb->get( '/me?fields=name,email', $accessToken );
        } catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
            return;
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
            return;
        }

        $facebook = $response->getGraphUser();
        $user     = Session::get( 'user' );
        if ( !empty( $facebook[ 'id' ] ) && !empty( $user ) ) {
            $user               = self::find( $user[ 'id' ] );
            $user[ 'facebook' ] = $facebook[ 'id' ];
            $user->save();
            Session::put( [ 'user' => $user ] );
        }
    }

    public static function getUser( &$request, &$data ) {
        $data[ 'pagination' ][ 'url' ] = url( "dashboard/users?page=" );

        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;
        if ( empty( $request[ 'find' ] ) ) {
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( self::count() / $limit );
            $data[ 'users' ]                 = self::offset( $offset )->limit( $limit )->get()->toArray();
        } else {
            $data[ 'users' ]                 = self::where( 'name', 'LIKE', "%{$request[ 'find' ]}%" );
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'users' ]->count() / $limit );
            $data[ 'users' ]                 = $data[ 'users' ]->offset( $offset )->limit( $limit )->get()->toArray();
        }
    }

    public static function getContentsById( &$id, &$data ) {
        if ( $user = self::find( $id ) ) {
            $data[ 'user' ] = $user->toArray();
        }
    }

    public static function updateByAdmin( &$request ) {
        DB::beginTransaction();
        try {

            $user = self::find( $request[ 'id' ] );

            $user[ 'name' ]     = $request[ 'name' ];
            $user[ 'email' ]    = $request[ 'email' ];
            $user[ 'role' ]     = $request[ 'role' ];
            if ( !empty( $user[ 'password' ] ) )
                $user[ 'password' ] = Hash::make( $user[ 'password' ] );
            else
                $user[ 'password' ] = $request[ 'password' ];


            $user->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'name' ]} ) user." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update user now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    public static function deleteUser( $id ) {
        DB::beginTransaction();
        try {

            $user = self::find( $id );
            $name = $user[ 'name' ];
            if ( $user ) {
//                self::pageBackup( 'delete', $category, 'trash-o' );
                $user->delete();

                DB::commit();
                Session::flash( 'sm', "You are successfull delete user ($name)" );
            } else {
                
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t delete user now please try after' );
        }
    }

    public static function addUser( &$request ) {
        DB::beginTransaction();
        try {

            $user            = new self;
            $user[ 'name' ]  = $request[ 'name' ];
            $user[ 'email' ] = $request[ 'email' ];
            $user[ 'role' ]  = $request[ 'role' ];
            $user->password  = Hash::make( $request[ 'password' ] );
            $user->facebook  = false;


            $user->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'name' ]} ) user." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update user now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    public static function changePass( &$request ) {
        $user = self::find( Session::get( 'user' )[ 'id' ] );
        if ( Hash::check( $request[ 'old' ], $user[ 'password' ] ) ) {
            $user->password = Hash::make( $request[ 'password' ] );
            $user->save();
            Session::put( [ 'user' => $user ] );

            Session::flash( 'sm', "You are update successfull your password." );

            return true;
        }
        Session::flash( 'wm', 'Worng Password!!!' );
        return false;
    }

}
