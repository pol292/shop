<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure,
    Session;

class Guest {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next ) {
        $user = Session::get( 'user' );
        User::login( $user );
        if ( !empty( $user ) && $user->login ) {
            return redirect( '/' );
        }

        return $next( $request );
    }

}
