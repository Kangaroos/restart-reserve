@extends('layouts.admin')
@section('title', '门店管理 - 锐思达预约系统后台管理')
@section('head')
@parent
@endsection
@section('content')
    <div id="sub-header" class="ui top attached menu">
        <div class="header item">
            <h5 class="ui header">
                <i class="building icon"></i>
                <div class="content">
                    门店管理
                    <div class="sub header">管理锐思达所有门店数据</div>
                </div>
            </h5>
        </div>
        {{--<div class="menu">--}}
            {{--<div class="ui right aligned category search item">--}}
                {{--<div class="ui transparent icon input">--}}
                    {{--<input class="prompt" type="text" placeholder="门店名称">--}}
                    {{--<i class="search link icon"></i>--}}
                {{--</div>--}}
                {{--<div class="results"></div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="right item">
            <button id="createStoreBtn" class="ui blue button">新增门店</button>
        </div>
    </div>
    <div id="content" class="ui basic segment">
        <div class="ui special cards">
            @if (count($stores) === 0)
                <div>没有数据</div>
            @elseif (count($stores) >= 1)
                @foreach($stores as $store)
                    <div data-id="{{ $store->id }}" class="ui card">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <div data-id="updateCoverBtn" class="ui inverted button">更换封面</div>
                                        <div data-id="editStoreBtn" class="ui inverted button">编辑</div>
                                        <div data-id="deleteStoreBtn" class="ui inverted button">删除</div>
                                    </div>
                                </div>
                            </div>
                            <img class="cover-image" src="{{ empty($store->file_entries_id) ? asset('/assets/images/store.jpg') : route('getfile', ['id' => $store->file_entries_id]) }}">
                            <input type="file" name="cover" class="hide cover-upload-input">
                        </div>
                        <div class="content">
                            <a class="header">{{ $store->name }}</a>

                            <div class="meta">
                                <span class="date">{{ $store->startup_at }}</span>

                                <div class="tel">电话：{{ $store->mobile }}</div>
                            </div>
                            <div class="description" title="{{ $store->description }}">{{ str_limit( $store->description, 200) }}</div>
                        </div>
                        <div class="extra content">
                            <span class="right floated">
                              <i class="marker icon"></i>
                              {{ $store->address }}
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/admin/store/list.js')  }}']);
    })
</script>
@endsection