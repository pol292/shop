<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;

class ManageUserController extends BaseDashboardController {

    public function __construct( Request $request ) {
        parent::__construct( $request );
        self::$data[ 'page' ] = 'User Manager';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        User::getUser( $request, self::$data );
        
        if ( self::$data[ 'pagination' ][ 'count' ] !== 0 && empty( self::$data[ 'users' ] ) ) {
            if ( !empty( $request[ 'find' ] ) )
                Session::flash( 'wm', 'You are search for: "' . $request->find . '" you are get 0 resualts.' );
            return redirect( 'dashboard/users?page=' . self::$data[ 'pagination' ][ 'count' ] );
        }
        return view( 'dashboard.user.view_all', self::$data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'dashboard.user.add', self::$data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( RegisterRequest $request ) {
        User::addUser( $request );
        return redirect( url( "dashboard/users/" ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
//    public function show( Request $request, $url ) {
//        
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        User::getContentsById( $id, self::$data );
        if ( !empty( self::$data[ 'user' ] ) ) {
            self::$data[ 'subtitle' ] = 'Edit: ' . self::$data[ 'user' ][ 'name' ];
            return view( 'dashboard.user.edit', self::$data );
        } else {
            return redirect( url( 'dashboard/user' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateUserRequest $request, $id ) {
        if ( $request[ 'id' ] == $id ) {
            User::updateByAdmin( $request );
        }
        return redirect( $request->path() . '/edit' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request, $id ) {
        User::deleteUser( $id );
        return response()->json( ($request[ 'redirect' ] ? [ 'redirect' => 'dashboard/users' ] : [] ) );
    }

}
