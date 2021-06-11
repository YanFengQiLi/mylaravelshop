<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class checkAuth extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $this->auth->getToken();

        if ($token) {
            try {
                // 检测用户的登录状态
                if ($this->auth->parseToken()->authenticate()) {
                    return $next($request);
                }
                return api_response(202, [], '请登录');
            } catch (TokenExpiredException $expiredException) {
                try {
                    // 刷新用户的 token
                    $token = $this->auth->refresh();

                    $access_token = 'Bearer '.$token;

                    $request->headers->set('Authorization', $access_token);

                    // 使用一次性登录以保证此次请求的成功  sub 获取的就是 当前 token 的 `用户ID`
                    \Auth::guard('api')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);

                    return $this->setAuthenticationHeader($next($request), $token);
                } catch (JWTException $JWTException) {
                    //  如果捕获到此异常，即代表 refresh 也过期了，用户无法刷新令牌，需要重新登录
                    return api_response(203, [],'账号信息已过期，请重新登录');
                }
            }
        }

        return $next($request);
    }
}
