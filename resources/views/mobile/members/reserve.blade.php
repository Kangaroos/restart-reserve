@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
@parent

@endsection
@section('body')
    <header class="head">
        <a class="back" href="javascript:history.back();"></a>
        <div class="logo">
            <img src="{{ asset('/assets/images/restart-logo.png') }}" title="锐思达健身">
        </div>
        <a class="home" href="/"></a>
    </header>
    <nav class="nav">
        <div class="title">我的预约</div>
    </nav>
    <div class="reserves">
        @foreach($reserves as $reserve)
        <div class="reserve">
            <div class="title"><h5>{{ $reserve->course->store->name }} {{ $reserve->course->classroom->name }}</h5></div>
            <div class="content">
                <span class="date">{{ date('m月d日',strtotime($reserve->course->class_date)) }}（{{ $reserve->course->week }}）15:00</span>
                @if($reserve->status == 'verify')
                    <button type="button" onclick="window.location = '{{ route('members.reserve.detail', $reserve->id) }}';">详情</button>
                @elseif($reserve->status=='complete')
                    <button type="button" disabled>已结束</button>
                @else
                    <button type="button" disabled>已取消</button>
                @endif
            </div>
            <span class="tag-status {{$reserve->cssStatus()}}"></span>
        </div>
        @endforeach
        {{--<div class="reserve">--}}
            {{--<div class="title history"><h5>锐思达正详店 动感单车室 5号</h5></div>--}}
            {{--<div class="content">--}}
                {{--<span class="date">7月14日（周一）15:00</span>--}}
                {{--<button disabled>已取消</button>--}}
            {{--</div>--}}
            {{--<span class="tag-status history"></span>--}}
        {{--</div>--}}
    </div>
@endsection

@section('end')
@parent
@endsection