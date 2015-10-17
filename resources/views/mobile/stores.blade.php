@extends('layouts.mobile')
@section('title', '锐思达预约')

@section('head')
@parent

@endsection
@section('body')
    <header class="head">
        <div class="logo">
            <img src="{{ asset('/assets/images/restart-logo.png') }}" title="锐思达健身">
        </div>
        <a class="user" href="#"></a>
    </header>
    <nav class="nav">
        <div class="title">锐思达课程预约</div>
    </nav>
    <div class="stores">
        @foreach($stores as $store)
            <div class="store" data-href="{{ route('store.courses', ['id' => $store->id]) }}">
                <div class="image">
                    <img src="{{ empty($store->file_entries_id) ? asset('/assets/images/store.jpg') : route('getfile', ['id' => $store->file_entries_id]) }}" title="{{ $store->name }}">
                </div>
                <div class="divider"></div>
                <div class="content">
                    <div class="title">{{ $store->name }}</div>
                    <div class="desc">{{ $store->address }}</div>
                    <div class="mobile">{{ $store->mobile }}</div>
                </div>
                <div class="arrow-right"></div>
            </div>
        @endforeach
    </div>
@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/mobile/stores.js')  }}']);
    })
</script>
@endsection