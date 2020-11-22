<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\WechatTokenService;
use Illuminate\Support\Facades\Request;

class VerifySelfToken
{
    private $verify;
    public function __construct(WechatTokenService $verify)
    {
        $this->verify = $verify;
    }

    public function handle($request, Closure $next)
    {
        try {
            $cryptToken = $this->verify->tokenverify($request);
            $this->verify->autograph($request, $cryptToken);
            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'serverTime' => time(),
                'serverNo' => $e->getCode(),
                'ResultData' => $e->getMessage()
            ]);
        }
    }
}