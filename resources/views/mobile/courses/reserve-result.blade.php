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
                <h1>预约成功</h1>
            </span>
        </div>
    </header>
    <div class="reserve-result">
        <div class="image">
            <img src="{{ asset('assets/images/white-block.png') }}">
            <div class="info">
                <h5 class="title">{{ $reserve->course->name }}</h5>
                <p>{{ $reserve->course->store->name }}</p>
                <p>{{ $reserve->course->classroom->name }}</p>
                <p class="green">预约{{ date('m月d日',strtotime($reserve->course->class_date)) }}（{{ $reserve->course->week }}）</p>
                <p>预约教练：{{ $reserve->course->coach->name }}</p>
                <p>会员卡号：{{ $reserve->user->card_number }}</p>
                <p>姓名：{{ $reserve->user->nickname }}</p>
                <p>手机号码：{{ $reserve->user->mobile }}</p>
                <p>核销码：{{ $reserve->order_no }}</p>
            </div>
            <div id="qrcode"></div>
        </div>
        <form class="sms-form">
            <input type="hidden" name="class_date" value="{{ date('m月d日',strtotime($reserve->course->class_date)) }}（{{ $reserve->course->week }}） {{ $reserve->course->class_time_begin }}">
            <input type="hidden" name="order_no" value="{{ $reserve->order_no }}">
            <input type="hidden" name="course_name" value="{{ $reserve->course->name }}">
            @if(empty(Auth::user()->card_number) === true)
            </form>
            <div class="tips">
                * “恭喜您预约成功,请等待工作人员与您联系!”
            </div>
            @else
                <input type="tel" name="mobile" value="{{ $reserve->user->mobile }}" readonly>
                <button type="button" class="send-otp">发短信</button>
                <button type="button" class="cancel-reserve">取消</button>
            </form>
            <div class="tips">
                * “请准时参加预约课程，若不能按时参加，请提前2个小时取消预约订单；若未取消订单，也未来参加预约课程，爽约次数达到3次，系统将自动关闭您的预约权限哦！”
            </div>
            @endif
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready(['bundle', 'material'], function(){
        $script(['//cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js'], function(){
            $script(['{{ asset('assets/webpack/mobile/courses/reserve-result.js')  }}']);
        });
    })
</script>
@endsection