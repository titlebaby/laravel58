@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        激活链接已发送至您的邮箱{{$user->email}},请于{{$user->activity_expire}}前激活您的账户。
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
