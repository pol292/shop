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
        self::setTitle( 'Register' );
        return view( 'user.register', self::$data );
    }

    public function postRegister( RegisterRequest $request ) {
        User::register( $request );
        return redirect( url( 'user/login' ) );
    }

    public function login() {

        $fb = new \Facebook\Facebook( [
            'app_id'                => '1969953169955602',
            'app_secret'            => '679d3d5350af5eec5b7d4753e3b5ad09',
            'default_graph_version' => 'v2.10',
                ] );

        
        $helper = $fb->getRedirectLoginHelper();
        
        self::$data[ 'facebook' ] = $helper->getLoginUrl( url( 'user/facebook' ), [ 'email' ] );

        self::setTitle( 'Login' );
        return view( 'user.login', self::$data );
    }

    public function postLogin( Request $request ) {
        User::login( $request, TRUE );
        return redirect( url( $request->redirect ) );
    }

    public function logout() {
        User::logout();
        return redirect( url( '/' ) );
    }

    public function facebook( Request $request ) {
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
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
        }

        $me = $response->getGraphUser();
        dd($me);
    }

}
