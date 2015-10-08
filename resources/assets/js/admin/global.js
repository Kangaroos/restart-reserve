define(['jquery', 'dust', '$script'], function($, dust, $script){
    $('#main-sidebar').sidebar('attach events', '#sidebar-menu');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
});