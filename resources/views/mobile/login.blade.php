@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
    @parent

@endsection
@section('body')
    <header class="head">
        <a class="back" href="javascript:history.back();"></a>
        <div class="logo">
            <span class="title">
                <h1>提交信息</h1>
            </span>
        </div>
    </header>
    @if($type == 'members')
        <div class="members-login">
            <div class="members-tab" data-url="{{ url('/login?type=members') }}">会员</div>
            <div class="non-members-tab" data-url="{{ url('/login?type=non-members') }}">非会员</div>
            <form action="{{ route('login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="login-type" value="{{ $type }}" >
                <div class="control">
                    <label>会员卡号</label>
                    <input type="text">
                </div>
                <div class="control">
                    <label>姓 名</label>
                    <input type="text">
                </div>
                <div class="control">
                    <label>手 机 号</label>
                    <input type="tel">
                </div>
                <div class="control">
                    <label>短信码</label>
                    <input type="number" class="otp">
                    <a class="otp-btn">点击获取</a>
                </div>
                <div class="control">
                    <button type="submit">提交</button>
                </div>
            </form>
        </div>
    @else
        <div class="non-members-login">
            <div class="members-tab" data-url="{{ url('/login?type=members') }}">会员</div>
            <div class="non-members-tab" data-url="{{ url('/login?type=non-members') }}">非会员</div>
            <form action="{{ route('login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="login-type" value="{{ $type }}" >
                <div class="control">
                    <label>姓 名</label>
                    <input type="text">
                </div>
                <div class="control">
                    <label>手 机 号</label>
                    <input type="tel">
                </div>
                <div class="control">
                    <label>短信码</label>
                    <input type="number" class="otp">
                    <a class="otp-btn">点击获取</a>
                </div>
                <div class="control">
                    <button type="submit">提交</button>
                </div>
            </form>
        </div>
    @endif

@endsection

@section('end')
    @parent
    <script>
        $script.ready('bundle', function(){
            $script(['{{ asset('assets/webpack/mobile/login.js')  }}']);
        })
    </script>
@endsection