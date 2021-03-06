<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure,
    Session;

class AuthAdmin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next ) {
        $user = Session::get( 'user' );
        User::login($user);
        if (empty($user) || !$user->login){
            return redirect('user/login?redirect='.$request->path());
        }elseif ($user->role != 3){
            return redirect('/');
        }
        
        return $next( $request );
    }

}
