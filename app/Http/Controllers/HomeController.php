<?php

namespace App\Http\Controllers;

use App\Model\Invoice;
use App\Notifications\InvoicePaid;
use App\User;
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


    public function shopping(){
        $user = User::find(1);
        $invoice = Invoice::where(['user_id'=>$user->id])->first();
        $user->notify(new InvoicePaid($invoice));

    }
}
