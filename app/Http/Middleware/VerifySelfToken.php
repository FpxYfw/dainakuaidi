<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\VerifyTokenService;

class VerifySelfToken
{
    private $verifyToken;

    function __construct(
        VerifyTokenService $verifyToken
    ) {
        $this->verifyToken = $verifyToken;
    }
    public function handle($request, Closure $next)
    {
        try {
            $param = $request->all();
            $routes = $request->path();
            $timeNow = time();

            $this->verifyToken->tokenService($request, $routes, $param, $timeNow);

            $response = $next($request);
            return response()->json([
                'serverTime' => time(),
                'serverNo' => 200,
                'ResultData' => json_decode($response->getContent(), true)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'serverTime' => time(),
                'serverNo' => $e->getMessage(),
                'ResultData' => $e->getMessage()
            ]);
        }
    }
}