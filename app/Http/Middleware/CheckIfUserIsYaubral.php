<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserIsYaubral
{
    /**
     * Checks if user is post or profile author (or is he admin)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_null(auth()->user())) {
            return redirect('login');
        }
        if (!auth()->user()->role == 'yaubral'
            && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return $next($request);
    }
}
