<?php

namespace App\Http\Middleware;

use Closure;

class EsewaPassMiddleware
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
        if(isset($_SERVER['HTTP_REQUESTUSERNAME']) && isset($_SERVER['HTTP_REQUESTPASSWORD'])){
            if(($_SERVER['HTTP_REQUESTUSERNAME']==='Esewatokenpay') && ($_SERVER['HTTP_REQUESTPASSWORD']==='EsewaToken@123'))
            {
                return $next($request);
            }
        }
        return response()->json([
            'status'=>false,
            'message'=>'Un Authorized'
        ]);

    }
}
