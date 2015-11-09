@extends('layouts.admin')
@section('title', '预约管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    预约管理
                    <div class="sub header">管理锐思达所有预约数据</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <button id="createReserveBtn" class="ui blue button">新增预约</button>
        </div>
    </div>
    <div id="content" class="ui basic segment">
    @if (count($reserves) === 0)
        <div>没有数据</div>
    @elseif (count($reserves) >= 1)
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>门店教室</th>
                <th>课程名称</th>
                <th>座位号</th>
                <th>会员名称</th>
                <th>核销码</th>
                <th>状态</th>
                <th>预约时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        @foreach($reserves as $reserve)
            <tr data-id="{{ $reserve->id }}">
                <td>{{ $reserve->course->store->name }} {{ $reserve->course->classroom->name }}</td>
                <td>{{ $reserve->course->name }}</td>
                <td>{{ $reserve->seat_number }}</td>
                <td>{{ $reserve->user->name }}</td>
                <td>{{ $reserve->order_no }}</td>
                <td>{{ $reserve->displayStatus() }}</td>
                <td>{{ $reserve->created_at }}</td>
                <td>
                    {{--<div data-id="editReserveBtn" class="ui blue button">编 辑</div>--}}
                    <div data-id="verifyReserveBtn" class="ui green button">核 销</div>
                    <div data-id="cancelReserveBtn" class="ui gray button">取 消</div>
                    <div data-id="deleteReserveBtn" class="ui red button">删 除</div>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
    @endif
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/admin/reserve/list.js')  }}']);
    })
</script>
@endsection