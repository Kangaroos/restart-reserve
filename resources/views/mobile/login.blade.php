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
            <div class="members-tab" data-url="{{ url('/auth/login?type=members') }}">会员</div>
            <div class="non-members-tab" data-url="{{ url('/auth/login?type=non-members') }}">非会员</div>
            <form action="{{ route('login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="login-type" value="{{ $type }}" >
                <input type="hidden" name="redirectTo" value="{{ $redirectTo }}" >
                <div class="control">
                    <label>会员卡号</label>
                    <input type="text" name="card_number" value="{{ old('card_number') }}">
                </div>
                <div class="control">
                    <label>姓 名</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="control">
                    <label>手 机 号</label>
                    <input type="tel" name="mobile" maxlength="11" value="{{ old('mobile') }}">
                </div>
                <div class="control">
                    <label>短信码</label>
                    <input type="tel" class="otp" maxlength="4" name="verifyCode">
                    <button id="sendVerifySmsButton" class="otp-btn">点击获取</button>
                </div>
                <div class="control">
                    <button type="button" id="postFormBtn">提交</button>
                </div>
            </form>
        </div>
    @else
        <div class="non-members-login">
            <div class="members-tab" data-url="{{ url('/auth/login?type=members') }}">会员</div>
            <div class="non-members-tab" data-url="{{ url('/auth/login?type=non-members') }}">非会员</div>
            <form action="{{ route('login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="login-type" value="{{ $type }}" >
                <input type="hidden" name="redirectTo" value="{{ $redirectTo }}" >
                <div class="control">
                    <label>姓 名</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="control">
                    <label>手 机 号</label>
                    <input type="tel" name="mobile" maxlength="11" value="{{ old('mobile') }}">
                </div>
                <div class="control">
                    <label>短信码</label>
                    <input type="tel" class="otp" maxlength="4" name="verifyCode">
                    <button id="sendVerifySmsButton" class="otp-btn">点击获取</button>
                </div>
                <div class="control">
                    <button type="button" id="postFormBtn">提交</button>
                </div>
            </form>
        </div>
    @endif

@endsection

@section('end')
    @parent
    <script>
        $script.ready(['bundle', 'material'], function(){
            $script(['{{ asset('assets/webpack/mobile/login.js')  }}']);
        })
    </script>
@endsection