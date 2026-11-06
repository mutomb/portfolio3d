<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackSiteVisit
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            SiteVisit::create([
                'path' => '/'.ltrim($request->path(), '/'),
                'ip_address' => $request->ip(),
                'user_agent' => Str::limit((string) $request->userAgent(), 500),
                'referrer' => Str::limit((string) $request->headers->get('referer'), 500) ?: null,
                'session_id' => Str::limit((string) $request->session()->getId(), 100),
            ]);
        } catch (Throwable) {
            // Analytics must never interrupt a visitor's request.
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($response->getStatusCode() >= 400) {
            return false;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        if ($request->user()?->isAdmin()) {
            return false;
        }

        return ! $request->is('admin', 'admin/*', 'login', 'up', 'build/*', 'uploads/*');
    }
}
