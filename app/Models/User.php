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
                }else{
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

    public static function facebookLogin( &$data ) {
        $fb = new \Facebook\Facebook( [
            'app_id'                => '1969953169955602',
            'app_secret'            => '679d3d5350af5eec5b7d4753e3b5ad09',
            'default_graph_version' => 'v2.10',
                ] );


        $helper = $fb->getRedirectLoginHelper();

        $data[ 'facebook' ] = $helper->getLoginUrl( url( 'user/facebook' ), [ 'email' ] );
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

}
