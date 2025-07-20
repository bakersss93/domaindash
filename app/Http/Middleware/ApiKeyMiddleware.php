<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\AccessLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $plainKey = $request->header('X-Api-Key');
        if (! $plainKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $apiKey = ApiKey::where('hashed_key', hash('sha256', $plainKey))->first();
        if (! $apiKey) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        if ($apiKey->expires_at && now()->greaterThan($apiKey->expires_at)) {
            return response()->json(['message' => 'API key expired'], 401);
        }

        if ($apiKey->allowed_ips) {
            $allowed = is_array($apiKey->allowed_ips)
                ? $apiKey->allowed_ips
                : explode(',', $apiKey->allowed_ips);
            $ip = $request->ip();
            if (! in_array($ip, $allowed)) {
                return response()->json(['message' => 'IP not allowed'], 403);
            }
        }

        $rateKey = 'api-key:'.$apiKey->id;
        if (RateLimiter::tooManyAttempts($rateKey, $apiKey->rate_limit)) {
            return response()->json(['message' => 'Rate limit exceeded'], 429);
        }
        RateLimiter::hit($rateKey);

        $response = $next($request);

        AccessLog::create([
            'api_key_id' => $apiKey->id,
            'endpoint' => $request->path(),
            'ip_address' => $request->ip(),
        ]);

        return $response;
    }
}
