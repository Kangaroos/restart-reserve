@extends('layouts.admin')
@section('title', '用户管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    用户管理
                    <div class="sub header">管理锐思达所有用户数据</div>
                </div>
            </h5>
        </div>
        <div class="right item">
            <div class="ui buttons">
                <button type="button" id="importUserBtn" class="ui button">导入用户</button>
                <div class="or"></div>
                <button type="button" id="exportUserBtn" class="ui positive button">导出用户</button>
            </div>
        </div>
    </div>
    <div id="content" class="ui basic segment">
        <div id="userTab" class="ui top attached tabular menu">
            <a class="active item" data-tab="first">会员</a>
            <a class="item" data-tab="second">非会员</a>
        </div>
        <div class="ui bottom attached active tab segment" data-tab="first">
            @if (count($members) === 0)
                <div>没有数据</div>
            @elseif (count($members) >= 1)
                <table class="ui selectable celled table">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>代用名</th>
                        <th>手机</th>
                        <th>会员卡号</th>
                        <th>爽约次数</th>
                        <th>会员等级</th>
                        <th>状态</th>
                        <th>注册时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $user)
                        <tr data-id="{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->card_number }}</td>
                            <td>{{ $user->fails_to_perform }}</td>
                            <td>{{ $user->level }}</td>
                            <td>{{ $user->status }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if ($user->status == 'inactive')
                                    <div data-id="auditUserBtn" class="ui green button">审 核</div>
                                @endif
                                <div data-id="editUserBtn" class="ui blue button">编 辑</div>
                                <div data-id="deleteUserBtn" class="ui red button">删 除</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! (new Landish\Pagination\SemanticUI($members))->render() !!}
            @endif
        </div>
        <div class="ui bottom attached tab segment" data-tab="second">
            @if (count($nonMembers) === 0)
                <div>没有数据</div>
            @elseif (count($nonMembers) >= 1)
                <table class="ui selectable celled table">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>代用名</th>
                        <th>手机</th>
                        <th>爽约次数</th>
                        <th>状态</th>
                        <th>注册时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nonMembers as $user)
                        <tr data-id="{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->fails_to_perform }}</td>
                            <td>{{ $user->status }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <div data-id="editUserBtn" class="ui blue button">编 辑</div>
                                <div data-id="deleteUserBtn" class="ui red button">删 除</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! (new Landish\Pagination\SemanticUI($nonMembers))->render() !!}
            @endif
        </div>
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/admin/user/list.js')  }}']);
    })
</script>
@endsection