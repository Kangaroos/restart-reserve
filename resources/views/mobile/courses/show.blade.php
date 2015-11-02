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
        <a class="user" href="{{ route('members') }}"></a>
    </header>

@endsection

@section('end')
@parent
<script>
    $script.ready('bundle', function(){
        $script(['{{ asset('assets/webpack/mobile/courses/show.js')  }}']);
    })
</script>
@endsection