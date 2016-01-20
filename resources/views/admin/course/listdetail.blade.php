@extends('layouts.admin')
@section('title', '课程列表 - 锐思达预约系统后台管理')
@section('head')
    @parent
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
        </div>
    </div>
    <div id="content" class="ui basic segment">

    @if (count($courseSchedules) === 0)
        <div>没有数据</div>
    @elseif (count($courseSchedules) >= 1)
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
        @foreach($courseSchedules as $courseSchedule)
            <tr data-id="{{ $courseSchedule->id }}">
                <td>{{ $courseSchedule->course->name }}</td>
                <td>{{ $courseSchedule->course->store->name }}</td>
                <td>{{ $courseSchedule->course->classroom->name }}</td>
                <td>{{ $courseSchedule->course->coach->name }}</td>
                <td>{{ $courseSchedule->class_date }}</td>
                <td>{{ $courseSchedule->course->class_time_begin }}</td>
                <td>{{ $courseSchedule->course->class_time_end }}</td>
                <td>{{ $courseSchedule->week }}</td>
                <td>{{ $courseSchedule->course->description }}</td>
                <td>{{ $courseSchedule->course->needing_attention }}</td>
                <td>
                    <div data-id="deleteCourseScheduleBtn" class="ui red button">删 除</div>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
        {!! (new Landish\Pagination\SemanticUI($courseSchedules))->render() !!}
    @endif
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $('div[data-id="deleteCourseScheduleBtn"]').on("click", function(e) {
            var tr = $(this).closest('tr'),schedule_id = tr.data('id');
            swal({
                title: "提示",
                text: "确定要删除课程?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: "取消"
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/courses/schedules/' + schedule_id,
                        method: 'DELETE',
                        dataType: 'json'
                    }).done(function(ret) {
                        swal.close();
                        location.reload();
                    }).fail(function() {
                        sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                    });
                }
            });
        });
    })
</script>
@endsection