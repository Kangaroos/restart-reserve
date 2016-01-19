@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
@parent

@endsection
@section('body')
    <header class="head">
        <div class="logo">
            <img src="{{ asset('/assets/images/restart-logo.png') }}" title="锐思达健身">
        </div>
        <a class="home" href="/"></a>
    </header>
    <nav class="nav">
        <div class="title">会员中心</div>
    </nav>
    <div class="member-info">
        <img src="{{ asset('assets/images/member-center-bg.jpg') }}">
        <ul>
            <li>{{ Auth::user()->name }}</li>
            <li>{{ Auth::user()->mobile }}</li>
            @if(empty(Auth::user()->card_number) === true)
            <li>非会员</li>
            @else
            <li>{{ Auth::user()->card_number }}</li>
            @endif
            <li>爽约次数: {{ Auth::user()->fails_to_perform }}</li>
        </ul>
    </div>
    <div class="members-menu">
        <div class="content">
            <a class="item" href="{{ route('members.reserve') }}">
                <span>我的预约</span>
                <i class="arrow-right-green-circle"></i>
            </a>
            {{--<a class="item" href="#">--}}
                {{--<span>我的优惠券</span>--}}
                {{--<i class="arrow-right-green-circle"></i>--}}
            {{--</a>--}}
            {{--<a class="item" href="#">--}}
                {{--<span>我的抵用券</span>--}}
                {{--<i class="arrow-right-green-circle"></i>--}}
            {{--</a>--}}
            {{--<a class="item" href="#">--}}
                {{--<span>我的兴趣小组</span>--}}
                {{--<i class="arrow-right-green-circle"></i>--}}
            {{--</a>--}}
        </div>
    </div>
@endsection

@section('end')
@parent
@endsection