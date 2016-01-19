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
                <div class="title">{{ $courseSchedule->course->classroom->name }}</div>
                <div class="date">{{ $courseSchedule->classDateTime() }}</div>
                <button type="button" class="btn-reserve">确定</button>
            </div>
            <div id="legend"></div>
        </div>
        <div id="seat-map" data-map="{{ $courseSchedule->course->classroom->seats_map }}" data-seats="{{ $courseSchedule->course->classroom->seats }}" data-unavailable="{{ $courseSchedule->unavailable() }}">
            <div class="front">{{ $courseSchedule->course->classroom->name }}教练区</div>
        </div>
    </div>
    <form method="post" action="{{ route('reserves.store') }}" class="hide">
        {{ csrf_field() }}
        <input type="hidden" id="selected-seats" name="seat_number">
        <input type="hidden" name="course_schedule_id" value="{{ $courseSchedule->id }}">
    </form>
    <input type="hidden" id="errorMsg" value="{{ session('error') }}">
    <input type="hidden" id="redirectUrl" value="{{ session('redirectUrl') }}">
@endsection

@section('end')
@parent
<script>
    $script.ready(['bundle'], function(){
        $script(['{{ asset('assets/webpack/mobile/courses/reserve.js')  }}']);
    })
</script>
@endsection