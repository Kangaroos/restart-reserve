@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
@parent

@endsection
@section('body')
    <header class="head">
        <a class="back" href="{{ url('/stores') }}"></a>
        <div class="logo">
            <img src="{{ asset('/assets/images/restart-logo.png') }}" title="锐思达健身">
        </div>
    </header>
    <nav class="nav">
        <div class="title">{{ $store->name }}</div>
    </nav>
    <div class="store-info">
        <div class="image">
            <img src="{{ empty($store->file_entries_id) ? asset('/assets/images/store.jpg') : route('getfile', ['id' => $store->file_entries_id]) }}" title="{{ $store->name }}">
        </div>
        <div class="content">
            <div class="address"><i class="pin-icon"></i> {{ $store->name }}</div>
            <div class="divider"></div>
            <div class="mobile"><i class="phone-icon"></i> {{ $store->mobile }}</div>
        </div>
    </div>

    <div class="courses">
        <span class="triangle"></span>
        <ul class="date-tab">
            <li><a class="item">{{ $dates['today'] }}</a></li>
            <li><a class="item active">{{ $dates['tomorrow'] }}</a></li>
            <li><a class="item">{{ $dates['day_after_tomorrow'] }}</a></li>
        </ul>
        <div class="divider"></div>
        <div class="course">
            <span class="name">动感单车</span>
            <span class="time">15:00-16:00</span>
            <span class="group">
                <a class="button">详情</a>
                <a class="button">预约</a>
            </span>
        </div>
        <div class="divider"></div>
    </div>
@endsection

@section('end')
@parent

@endsection