<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserIsAuthor
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
        if ($request->author != auth()->user()->id
            && $request->user_id != auth()->user()->id
            && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return $next($request);
    }
}
