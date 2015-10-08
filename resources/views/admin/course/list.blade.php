@extends('layouts.admin')
@section('title', '课程管理 - 锐思达预约系统后台管理')
@section('head')
    @parent
    <link rel="stylesheet" href="//cdn.bootcss.com/fullcalendar/2.4.0/fullcalendar.min.css" />
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    课程管理
                    <div class="sub header">管理锐思达所有门店教室课程</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <button id="createCourseBtn" class="ui blue button">新增课程</button>
        </div>
    </div>
    <div id="content" class="ui basic segment">
    @if (count($courses) === 0)
        <div>没有数据</div>
    @elseif (count($courses) >= 1)
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>课程名称</th>
                <th>所属门店</th>
                <th>教室</th>
                <th>教练</th>
                <th>课程日期</th>
                <th>课程开始时间</th>
                <th>课程结束时间</th>
                <th>星期</th>
                <th>描述</th>
                <th>注意事项</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        @foreach($courses as $course)
            <tr data-id="{{ $course->id }}">
                <td>{{ $course->name }}</td>
                <td>{{ $course->store_name }}</td>
                <td>{{ $course->classroom_name }}</td>
                <td>{{ $course->coach_name }}</td>
                <td>{{ $course->class_date }}</td>
                <td>{{ $course->class_time_begin }}</td>
                <td>{{ $course->class_time_end }}</td>
                <td>{{ $course->week }}</td>
                <td>{{ $course->description }}</td>
                <td>{{ $course->needing_attention }}</td>
                <td>
                    {{--<div data-id="editCourseBtn" class="ui blue button">编 辑</div>--}}
                    <div data-id="deleteCourseBtn" class="ui red button">删 除</div>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
    @endif
    </div>
    <input type="hidden" id="stores" value="{{ $stores }}">
    <input type="hidden" id="coaches" value="{{ $coaches }}">
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['//cdn.bootcss.com/fullcalendar/2.4.0/fullcalendar.min.js'], function(){
            $script(['//cdn.bootcss.com/fullcalendar/2.4.0/lang/zh-cn.js']);
            $script(['{{ asset('assets/webpack/admin/course/list.js')  }}']);
        });
    })
</script>
@endsection