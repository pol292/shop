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
            $user->save();
            Session::flash( 'sm', 'Hello ' . $user->name . ', you are successfull register.' );
        }
    }

    public static function login( &$request, $new = false ) {
        if ( $user = self::where( 'email', $request[ 'email' ] )->first() ) {
            $check = $user->email == $request[ 'email' ] &&
                    Hash::check( $request[ 'password' ], $user->password );
            if ( $check ) {
                if ( $new ) {
                    Session::put( [ 'user' => $user ] );
                    $request->redirect = !empty($request->redirect)? $request->redirect : '/';  
                }
            } else {
                Session::forget( 'user' );
                if ( $new ) {
                    Session::flash( 'wm', 'Worng email or password please try again.' );
                    $request->redirect = 'user/login';
                }
            }
        }
    }
    
    public static function logout(){
        Session::forget('user');
    }

}
