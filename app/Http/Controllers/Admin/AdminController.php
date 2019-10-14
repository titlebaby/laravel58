<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\AdminRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{

    //返回用户列表
    public function index(){
        //3个用户为一页
        $users = Admin::paginate(3);
        //return $this->success($users);
        //返回用户列表 (资源列表)
        return AdminResource::collection($users);
    }


    //返回单一用户信息
    public function show(Admin $user){
            //return $this->success($user);
        //返回单一用户 (单一的资源)
        return $this->success(new AdminResource($user));
    }


    //用户注册
    public function store(AdminRequest $request)
    {
        $res = Admin::create($request->all());
        return $this->success('用户注册成功。。。');
    }

    //用户登录
    public function login(Request $request)
    {
        // 自动区分gard
//        $token = Auth::guard('admin')->attempt(
//            ['name' => $request->name,
//             'password' => $request->password
//            ]
//        );
        //获取当前守护的名称
        $present_guard =Auth::getDefaultDriver();
        // token的载荷信息中加入标志
        $token = Auth::claims(['guard'=>$present_guard])
            ->attempt(
                [
                    'name' => $request->name,
                    'password' => $request->password
                ]);

        if ($token) {
           // return $this->success('用户登录成功...');
            //or 自定义 http 状态码的正确信息
           // return $this->setStatusCode(201)->success('用户登录成功...');
            //带上token值
            return $this->setStatusCode(201)
                ->success(['token' => 'bearer ' . $token]);
        }
        //return $this->failed("用户登陆失败");
        //return $this->failed("用户登陆失败",401);
        //返回具体的错误状态码
        return $this->failed("用户登陆失败",401,100001);
    }

    //用户退出
    public function logout(){
        Auth::guard('admin')->logout();
        return $this->success('退出成功...');
    }

    //返回当前登录用户信息
    public function info(){
        //$user = Auth::guard('admin')->user();
        //自动区分guard
        $user = Auth::user();
        return $this->success(new AdminResource($user));
    }
}
