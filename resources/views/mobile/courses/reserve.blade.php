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
        <div class="logo">
            <img src="{{ asset('/assets/images/restart-logo.png') }}" title="锐思达健身">
        </div>
        <a class="user" href="{{ route('members') }}"></a>
    </header>
    <div class="seats">
        <div class="header">
            <div class="info">
                <div class="title">功能教室</div>
                <div class="date">今天7月14日 周一 15:00</div>
                <button>确定</button>
            </div>
            <div id="legend"></div>
        </div>
        <div id="seat-map">
            <div class="front">功能教室教练区</div>
        </div>
    </div>
    <form method="post" action="" class="hide">
        <input type="hidden" id="selected-seats" name="seats">
    </form>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/mobile/courses/reserve.js')  }}']);
    })
</script>
@endsection