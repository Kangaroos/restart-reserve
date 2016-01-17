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
                <h5 class="title">{{ $reserve->courseSchedule->course->name }}</h5>
                <p>{{ $reserve->courseSchedule->course->store->name }}</p>
                <p>{{ $reserve->courseSchedule->course->classroom->name }}</p>
                <p class="green">预约{{ date('m月d日',strtotime($reserve->courseSchedule->class_date)) }}（{{ $reserve->courseSchedule->week }}）</p>
                <p>预约教练：{{ $reserve->courseSchedule->course->coach->name }}</p>
                <p>会员卡号：{{ $reserve->user->card_number }}</p>
                <p>姓名：{{ $reserve->user->nickname }}</p>
                <p>手机号码：{{ $reserve->user->mobile }}</p>
                <p>核销码：{{ $reserve->order_no }}</p>
            </div>
            <div id="qrcode"></div>
        </div>
        <div class="tips">
            *“请准时参加预约课程，若不能按时参加，请提前2个小时取消预约订单；若未取消订单，也未来参加预约课程，爽约次数达到3次，系统将自动关闭您的预约权限哦！”
        </div>
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready(['bundle'], function(){
        $script(['//cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js'], function(){
            $('#qrcode').qrcode('{{ $reserve->order_no }}')
        });
    });
</script>
@endsection