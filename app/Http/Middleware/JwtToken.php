<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtToken
{
    /**
     * JWT 中间件
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $token =$request->header('authorization');

        try {
            $info = JWTAuth::setToken($token)->getPayload()->get('sub');

            $request->attributes->add(['member' => $info]);

            return $next($request);
        } catch (TokenExpiredException $expiredException) {
            return api_response(202, [], '验证失败, token失效');
        } catch (JWTException $exception) {
            return api_response(203, [], '验证失败, token无效');
        }
    }
}
