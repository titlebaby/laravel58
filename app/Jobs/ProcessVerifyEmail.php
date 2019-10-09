<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ProcessVerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //接受，只有可识别出该模型的属性（主键）会被序列化到队列里
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        Mail::raw(
            '请在' . $user->activity_expire . '前,点击链接激活您的账号' , function ($message) use ($user) {
            $message->from(env("MAIL_USERNAME"), '改写老王Laravel入门')
                ->subject('注册激活邮件')
                ->to($user->email);
        });
        //执行发送邮件通知
//        Mail::raw(
//            '请在' . $user->activity_expire . '前,点击链接激活您的账号' . route('user.activity',
//                ['token' => $user->activity_token]), function ($message) use ($user) {
//            $message->from(env("MAIL_USERNAME"), '改写老王Laravel入门')
//                ->subject('注册激活邮件')
//                ->to($user->email);
//        });
    }
}
