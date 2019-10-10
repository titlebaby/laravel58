<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\ApiUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    //返回用户列表
    public function index(){
        //3个用户为一页
        $users = ApiUser::paginate(3);
        //return $this->success($users);
        //返回用户列表 (资源列表)
        return UserResource::collection($users);
    }


    //返回单一用户信息
    public function show(ApiUser $user){
            //return $this->success($user);
        //返回单一用户 (单一的资源)
        return $this->success(new UserResource($user));
    }


    //用户注册
    public function store(UserRequest $request)
    {
        ApiUser::create($request->all());
        return $this->success('用户注册成功。。。');
    }

    //用户登录
    public function login(Request $request)
    {
        $res = Auth::guard('web')->attempt(
            ['name' => $request->name,
             'password' => $request->password
            ]
        );
        if ($res) {
           // return $this->success('用户登录成功...');
            //or 自定义 http 状态码的正确信息
            return $this->setStatusCode(201)->success('用户登录成功...');
        }
        //return $this->failed("用户登陆失败");
        //return $this->failed("用户登陆失败",401);
        //返回具体的错误状态码
        return $this->failed("用户登陆失败",401,100001);
    }
}
