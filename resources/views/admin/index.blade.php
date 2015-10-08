@extends('layouts.admin')
@section('title', '首页 - 锐思达预约系统后台管理')

@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="dashboard icon"></i>
                <div class="content">
                    控制面板
                    <div class="sub header">锐思达预订系统后台管理首页</div>
                </div>
            </h5>
        </div>
        {{--<div class="right menu">--}}
            {{--<div class="ui right aligned category search item">--}}
                {{--<div class="ui transparent icon input">--}}
                    {{--<input class="prompt" type="text" placeholder="Search animals...">--}}
                    {{--<i class="search link icon"></i>--}}
                {{--</div>--}}
                {{--<div class="results"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
    <div id="content" class="ui basic segment">

    </div>
@endsection

@section('end')
@parent

@endsection