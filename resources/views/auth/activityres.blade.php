@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Activity Result') }}</div>

                    <div class="card-body">
                        @if($res === false)
                            该链接已失效，请重新<a href="{{route('register')}}">注册>></a>
                        @else
                            您的账号已经激活，请<a href="{{route('login')}}">登录>></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
