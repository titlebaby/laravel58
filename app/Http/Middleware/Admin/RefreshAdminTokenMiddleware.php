<?php

namespace App\Http\Middleware\Admin;


use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshAdminTokenMiddleware extends BaseMiddleware
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


       //检查此次请求中是否带有token，如果没有则抛出异常
        //这个函数只会检测是否携带token以及token是否能被当前密钥所解析
        /**
         * 此方法不能解决前后token串的问题
         */
        $this->checkForToken($request);

        /**
         * 解决如下：增加如下代码 生成token时候生成标志，即是当前的gard
         */
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        //获取当前token
        $token=Auth::getToken();
        //即使过期了，也能获取到token里的 载荷 信息。
        $payload = Auth::manager()->getJWTProvider()->decode($token->get());
        //如果不包含guard字段或者guard所对应的值与当前的guard守护值不相同
        //证明是不属于当前guard守护的token
        if(empty($payload['guard'])||$payload['guard']!=$present_guard){
            throw new TokenInvalidException();
        }

        //--------添加判断结束---------
        //使用 try 包裹，以捕捉 token 过期所抛出的 TokenExpiredException  异常
        //2. 此时进入的都是属于当前guard守护的token
        try{
            //检测用户的登陆状态，如果正常则通过
            //将使用token进行登录，如果token过期，则抛出 TokenExpiredException 异常
            if($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }
            throw new UnauthorizedHttpException('jwt-auth','未登陆');

        }catch (TokenExpiredException $exception) {
            //此处捕获到了token 过期所抛出的TokenExpiredException
            //异常，在这里需要做的是刷新该用户token，并将它添加到响应头中
            try{
                $token = $this->auth->refresh();
                //使用一次性登陆以保证此次请求成功
                $sub = $this->auth->manager()->getPayloadFactory()
                           ->buildClaimsCollection()
                           ->toPlainArray()['sub'];
                Auth::guard('api')->onceUsingId($sub);
            }catch (JWTException $exception) {
                //如果捕获到此异常，即代表refresh也过期了，
                //用户无法刷新令牌，需要重新登陆
                throw new UnauthorizedHttpException('jwt-auth',$exception->getMessage());
            }
        }
        return $this->setAuthenticationHeader($next($request),$token);
        //return $next($request);
    }

}
