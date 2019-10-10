<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVerifyEmail;
use App\Model\Invoice;
use App\Notifications\InvoicePaid;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       // dd(Auth::check(),Auth::user());
        //dd(Auth::guard()->user());
        return view('home');
    }


    /**
     *消息通知
     */
    public function shopping(){
        $user = User::find(1);
        $invoice = Invoice::where(['user_id'=>$user->id])->first();
        $user->notify(new InvoicePaid($invoice));

    }

    /**
     * 查看队列运行过程
     * 1、先分发到队列
     * 2、链接redis客服端查看：
     *      redis-cli -h 127.0.0.1 -p 6379
     *      查看redis中队列键 ：keys *
     * 3、 启动队列处理：（清晰的看到处理过程，成功还是失败）
     *          php artisan queue:work  --tries=3
     *
     * 安卓redis扩展
     * composer require predis/predis
     * 终端翻墙
     * export http_proxy=http://127.0.0.1:1087
     */
    public function redisQueue(){

        $user = User::find(1);
        ProcessVerifyEmail::dispatch($user);

        ProcessVerifyEmail::dispatch($user)->delay(now()->addMinutes(2));

    }
}
