<?php

namespace App\Http\Middleware;

use Closure;

class FullyVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {       
        if(auth()->user()->fullyVerified){            
            return $next($request);
        }

        return redirect('home')->with('flash', 'Bitte bestätige deien Email-Adresse und warte auf die Profil-Freigabe.', 'danger');
        
    }
}
