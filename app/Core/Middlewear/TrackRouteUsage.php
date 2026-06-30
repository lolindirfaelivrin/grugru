<?php
#https://medium.com/@annxsa/deleting-40-of-a-php-codebase-and-having-nothing-break-heres-how-0035af9bfe27
class TrackRouteUsage
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()?->getName()
            ?? $request->route()?->uri()
            ?? 'unnamed';
        // Increment a counter with a 180-day TTL
        $key = "route_usage:$routeName";
        Redis::incr($key);
        Redis::expire($key, 180 * 86400);
        // Record last-seen timestamp
        Redis::set("route_last_seen:$routeName", time());
        return $next($request);
    }
}
?>
