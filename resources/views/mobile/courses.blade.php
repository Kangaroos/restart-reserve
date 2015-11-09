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
            <li><a class="item" data-class=".today">{{ $dates['today'] }}</a></li>
            <li><a class="item active" data-class=".tomorrow">{{ $dates['tomorrow'] }}</a></li>
            <li><a class="item" data-class=".day-after-tomorrow">{{ $dates['day_after_tomorrow'] }}</a></li>
        </ul>
        <div class="divider"></div>
        <div class="today">
            @foreach( $courses['today'] as $course)
            <div class="course">
                <span class="name">{{ $course->name }}</span>
                <span class="time">{{ $course->class_time_begin }}-{{ $course->class_time_end }}</span>
                <span class="group">
                    <a class="button detail" href="#" data-course="{{ $course }}" data-coach="{{ $course->coach }}">详情</a>
                    <a class="button" href="{{ route('course.reserve', $course->id) }}">预约</a>
                </span>
            </div>
            <div class="divider"></div>
            @endforeach
        </div>
        <div class="tomorrow show">
            @foreach( $courses['tomorrow'] as $course)
            <div class="course">
                <span class="name">{{ $course->name }}</span>
                <span class="time">{{ $course->class_time_begin }}-{{ $course->class_time_end }}</span>
                <span class="group">
                    <a class="button detail" href="#" data-course="{{ $course }}" data-coach="{{ $course->coach }}">详情</a>
                    <a class="button" href="{{ route('course.reserve', $course->id) }}">预约</a>
                </span>
            </div>
            <div class="divider"></div>
            @endforeach
        </div>
        <div class="day-after-tomorrow">
            @foreach( $courses['day_after_tomorrow'] as $course)
            <div class="course">
                <span class="name">{{ $course->name }}</span>
                <span class="time">{{ $course->class_time_begin  }}-{{ $course->class_time_end }}</span>
                <span class="group">
                    <a class="button detail" href="#" data-course="{{ $course }}" data-coach="{{ $course->coach }}">详情</a>
                    <a class="button" href="{{ route('course.reserve', $course->id) }}">预约</a>
                </span>
            </div>
            <div class="divider"></div>
            @endforeach
        </div>
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/mobile/courses.js')  }}']);
    })
</script>
@endsection