<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->header('X-API-KEY');
        if (!$token) {
            return response()->json(['message' => 'API token required'], Response::HTTP_UNAUTHORIZED);
        }

        $hashed = hash('sha256', $token);
        $apiKey = ApiKey::where('hashed_key', $hashed)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$apiKey) {
            return response()->json(['message' => 'Invalid API token'], Response::HTTP_UNAUTHORIZED);
        }

        if ($apiKey->allowed_ips) {
            $allowed = is_array($apiKey->allowed_ips) ? $apiKey->allowed_ips : explode(',', $apiKey->allowed_ips);
            $ip = $request->ip();
            if (!in_array($ip, array_map('trim', $allowed), true)) {
                return response()->json(['message' => 'IP not allowed'], Response::HTTP_FORBIDDEN);
            }
        }

        /** @var RateLimiter $limiter */
        $limiter = app(RateLimiter::class);
        $key = 'api-key:' . $apiKey->id;
        $maxAttempts = $apiKey->rate_limit ?? 60;
        if ($limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests'], Response::HTTP_TOO_MANY_REQUESTS);
        }
        $limiter->hit($key, 60);

        $apiKey->update(['access_logs' => array_merge($apiKey->access_logs ?? [], [
            [
                'ip' => $request->ip(),
                'path' => $request->path(),
                'time' => now()->toDateTimeString(),
            ]
        ])]);

        Log::info('API access', ['key_id' => $apiKey->id, 'ip' => $request->ip(), 'path' => $request->path()]);

        return $next($request);
    }
}
