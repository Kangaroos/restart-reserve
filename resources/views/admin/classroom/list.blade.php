@extends('layouts.admin')
@section('title', '教室管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    教室管理
                    <div class="sub header">管理锐思达所有门店教室</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <button id="createClassroomBtn" class="ui blue button">新增教室</button>
        </div>
    </div>
    <div id="content" class="ui basic segment">
    @if (count($classrooms) === 0)
        <div>没有数据</div>
    @elseif (count($classrooms) >= 1)
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>教室名称</th>
                <th>所属门店</th>
                <th>描述</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        @foreach($classrooms as $classroom)
            <tr data-id="{{ $classroom->id }}">
                <td>{{ $classroom->name }}</td>
                <td>{{ $classroom->store->name }}</td>
                <td title="{{ $classroom->description }}">{{ str_limit( $classroom->description, 60) }}</td>
                <td>{{ $classroom->status }}</td>
                <td>
                    <div data-id="editClassroomBtn" class="ui blue button">编 辑</div>
                    <div data-id="deleteClassroomBtn" class="ui red button">删 除</div>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>
        {!! (new Landish\Pagination\SemanticUI($classrooms))->render() !!}
    @endif
    </div>
    <input type="hidden" id="stores" value="{{ $stores }}">
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/admin/classroom/list.js')  }}']);
    })
</script>
@endsection