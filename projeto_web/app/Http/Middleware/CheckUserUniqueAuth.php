<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserUniqueAuth
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
        
        if (auth()->user()->token_access != session()->get('access_token')) {
        
            \Auth::logout();
    
            return redirect()
                        ->route('login')
                        ->with('message', 'A sessão deste usuário está ativa em outro local!');
        }
    
        // Permite o acesso, continua a requisição
        return $next($request);
    }
}
