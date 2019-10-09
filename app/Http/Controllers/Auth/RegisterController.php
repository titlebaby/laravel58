<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\ProcessVerifyEmail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'activity_token'  => Str::random(60),
            'activity_expire' => Date::now('+1 days'),
            'name'            => $data['name'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        //触发事件??次处的事件没有起效？？？
        event(new Registered($user));
        //分发任务
        //ProcessVerifyEmail::dispatch($user);
        //显示注册激活提示信息
        return view('auth.registed',['user'=>$user]);
    }

    function activity($token){
        $user = User::where(['activity_token'=>$token])->first();
        if(!$user) {
            return ['令牌错误'];
        }
        $res = false;
        if($user && strtotime($user->activity_expire)>time())
        {
            $user->is_activity = 1;
            $res = $user->save();
        }
        return view('auth.activityres',['res'=>$res]);
    }
}
