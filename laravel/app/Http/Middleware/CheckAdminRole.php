<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        // Allow Admin or Operator
        if ($user->isAdmin() || $user->isOperator()) {
            return $next($request);
        }

        // Standard user or others trying to access admin route
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access the administration portal.');
    }
}
