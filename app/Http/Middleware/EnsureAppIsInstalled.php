<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureAppIsInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     * @throws BindingResolutionException
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if(!app()->make('app.installed'))
            return redirect()->route('installer.index');

        return $next($request);
    }
}
