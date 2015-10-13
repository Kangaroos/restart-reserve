@extends('layouts.admin')
@section('title', '教练管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    教练管理
                    <div class="sub header">管理锐思达所有教练数据</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <button id="createCoachBtn" class="ui blue button">新增教练</button>
        </div>
    </div>
    <div id="content" class="ui basic segment">
    @if (count($coaches) === 0)
        <div>没有数据</div>
    @elseif (count($coaches) >= 1)
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>教练名称</th>
                <th>描述</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        @foreach($coaches as $coach)
            <tr data-id="{{ $coach->id }}">
                <td>{{ $coach->name }}</td>
                <td title="{{ $coach->description }}">{{ str_limit( $coach->description, 60) }}</td>
                <td>{{ $coach->status }}</td>
                <td>
                    <div data-id="editCoachBtn" class="ui blue button">编 辑</div>
                    <div data-id="deleteCoachBtn" class="ui red button">删 除</div>
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
        $script(['{{ asset('assets/webpack/admin/coach/list.js')  }}']);
    })
</script>
@endsection