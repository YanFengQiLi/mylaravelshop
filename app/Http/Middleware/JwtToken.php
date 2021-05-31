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
     *
     * 关于 jwt 的理解, 个人认为比较好得文章： https://learnku.com/articles/10885/full-use-of-jwt
     *
     * token 续签方式：
     *   服务端接管刷新
     *   token 设置一个『过期时间』
     *   token 过期后但是仍在『刷新时间』内时仍然可刷新
     *   token 过期后超过『刷新时间』就不能再刷新，需重新登录
     *
     */
    public function handle($request, Closure $next)
    {
        $boolean = JWTAuth::parseToken()->check();

        //  校验 token 有效性 (注：此处与过期时间无关, 即便过期也可以使用)
        if ($boolean === false) {
            return api_response(203, [], '验证失败, token 无效');
        }

        //  解析 jwt 载荷
        $payload = JWTAuth::parseToken()->getPayload();

        //  $exp-过期时间 $iat-签发时间
        list($exp, $iat) = [$payload->get('exp'), $payload->get('iat')];

        //  获取刷新时间
        $refreshTTL = ( config('jwt.refresh_ttl') * 60 ) + $iat;

        //  获取当前时间
        $nowTime = time();

        if ($nowTime < $exp && $nowTime <= $refreshTTL) {
            return $next($request);
        } elseif ($nowTime > $exp && $nowTime <= $refreshTTL) {
            $token = JWTAuth::parseToken()->refresh();

            response()->header('Authorization', $token);

            return $next($request);
        } else {
            return api_response(202, [], '验证失败, token 过期');
        }
    }
}
