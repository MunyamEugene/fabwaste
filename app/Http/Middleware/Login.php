<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user=User::where('email',$request->input('email'))->first();
        if($user==null){
          return Response::json(['error' => 'User with_' . $request->input('email'). '_is not registered'], 400); 
        }else if ($user->isadmin == true|| $user->ismanufacture==true || $user->isapproved==true) {
            return $next($request);
        }else{
        return Response::json(['error' => 'your account has not been approved'], 403); 
        } 
    }
}
