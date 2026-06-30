<?php
trait TracksMethodUsage
{
    protected function traceUsage(string $method): void
    {
        if (!config('audit.trace_enabled', false)) {
            return;
        }
        $class = static::class;
        Redis::incr("method_usage:$class::$method");
        Redis::expire("method_usage:$class::$method", 180 * 86400);
    }
}
?>
