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
        if(isset($_SERVER['HTTP_GUSERNAME']) && isset($_SERVER['HTTP_GPASSWORD'])){
            if(($_SERVER['HTTP_GUSERNAME']==='gNetwork') && ($_SERVER['HTTP_GPASSWORD']==='gNetowrk@123@#'))
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
