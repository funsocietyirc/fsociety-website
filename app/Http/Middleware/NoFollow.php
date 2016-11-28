<?php

namespace Fsociety\Http\Middleware;

// Prevent indexing
use Closure;

class NoFollow
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
        /** @var Request $response */
        $response = $next($request);
        $response->header('X-Robots-Tag', 'noindex, nofollow');
        return $response;
    }
}
