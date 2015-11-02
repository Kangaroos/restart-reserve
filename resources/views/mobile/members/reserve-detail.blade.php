@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
@parent
<script>
    $script(['{{ asset('assets/webpack/mobile-flex.scss.js') }}']);
</script>
@endsection
@section('body')
    <header class="head">
        <a class="back" href="javascript:history.back();"></a>
        <div class="logo">
            <span class="title">
                <h1>我的预约</h1>
            </span>
        </div>
    </header>
    <div class="reserve-result">
        <div class="image">
            <img src="{{ asset('assets/images/white-block.png') }}">
            <div class="info">
                <h5 class="title">动感单车</h5>
                <p>锐思达正祥店</p>
                <p>动感单车室 5号</p>
                <p class="green">预约7月14日（周一）</p>
                <p>预约教练：代用名</p>
                <p>会员卡号：88888888</p>
                <p>姓名：代用名</p>
                <p>手机号码：1388888888</p>
                <p>核销码：8888888</p>
            </div>
        </div>
        <div class="tips">
            *“请准时参加预约课程，若不能按时参加，请提前2个小时取消预约订单；若未取消订单，也未来参加预约课程，爽约次数达到3次，系统将自动关闭您的预约权限哦！”
        </div>
    </div>
@endsection

@section('end')
@parent
@endsection