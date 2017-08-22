<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;
use App\Models\Shop\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Session;

class UserController extends MainController {

    public function register() {
        User::facebookLogin( self::$data );
        self::setTitle( 'Register' );
        return view( 'user.register', self::$data );
    }

    public function postRegister( RegisterRequest $request ) {
        User::register( $request );
        return redirect( url( '/' ) );
    }

    public function login() {
        User::facebookLogin( self::$data );
        self::setTitle( 'Login' );
        return view( 'user.login', self::$data );
    }

    public function postLogin( Request $request ) {
        User::login( $request );
        return redirect( url( $request->redirect ) );
    }

    public function logout() {
        User::logout();
        return redirect( url( '/' ) );
    }

    public function facebook() {
        User::facebookAuth( self::$data );
        if ( empty( self::$data[ 'facebook' ] ) ) {
            return redirect( url( '/' ) );
        }
        return view( 'user.facebook_register', self::$data );
    }

}
