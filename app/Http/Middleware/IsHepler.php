<?php

namespace App\Http\Middleware;

use Closure;

class IsHepler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $helper)
    {               
        if(auth()->user()->helper === boolval($helper)){            
            return $next($request);
        }

        return redirect('home');
        
    }
}
