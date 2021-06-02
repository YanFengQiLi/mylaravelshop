<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtToken extends BaseMiddleware
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
        //  判断当前请求是否携带 token
        $token = $this->auth->getToken();

        if (! $token) {
            return api_response(201, [], '请求错误');
        }

        try {
            // 检测用户的登录状态
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            return api_response(202, [], '请登录');
        } catch (TokenExpiredException $exception) {
            //  捕获 token 过期错误
            try {
                // 刷新用户的 token
                $token = $this->auth->refresh();

                $access_token = 'Bearer '.$token;

                $request->headers->set('Authorization', $access_token);

                // 使用一次性登录以保证此次请求的成功  sub 获取的就是 当前 token 的 `用户ID`
                \Auth::guard('api')->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()['sub']);
            } catch (JWTException $JWTException) {
                //  如果捕获到此异常，即代表 refresh 也过期了，用户无法刷新令牌，需要重新登录
                return api_response(203, [],'账号信息已过期，请重新登录');
            }
        }

        //  在响应中添加已经刷新的 token
        return $this->setAuthenticationHeader($next($request), $token);
    }
}
