@extends('layouts.admin')
@section('title', '角色管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    角色管理
                    <div class="sub header">管理锐思达所有角色数据</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <div class="ui buttons">
                <button id="createRoleBtn" class="ui blue button">新增角色</button>
            </div>
        </div>
    </div>
    <div id="content" class="ui basic segment">
    @if (count($roles) === 0)
        <div>没有数据</div>
    @elseif (count($roles) >= 1)
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>角色名称</th>
                <th>Slug</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        @foreach($roles as $role)
            <tr data-id="{{ $role->id }}">
                <td>{{ $role->name }}</td>
                <td>{{ $role->slug }}</td>
                <td>{{ $role->description }}</td>
                <td>{{ $role->created_at }}</td>
                <td>
                    <div data-id="editRoleBtn" class="ui blue button">编 辑</div>
                    <div data-id="deleteRoleBtn" class="ui red button">删 除</div>
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
        $script(['{{ asset('assets/webpack/admin/role/list.js')  }}']);
    })
</script>
@endsection