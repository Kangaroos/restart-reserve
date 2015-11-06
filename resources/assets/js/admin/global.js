define(['jquery', 'dust', '$script'], function($, dust, $script){
    $('#main-sidebar').sidebar('attach events', '#sidebar-menu');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.fn.serializeObject = function () {
        var obj = {};
        var count = 0;
        $.each(this.serializeArray(), function (i, o) {
            var n = o.name, v = o.value;
            count++;
            obj[n] = obj[n] === undefined ? v
                : $.isArray(obj[n]) ? obj[n].concat(v)
                : [obj[n], v];
        });
        return JSON.stringify(obj);
    };

    $('#logoutAdminSystemBtn').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');

        swal({
            title: "提示",
            text: "确定要退出系统吗?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                location.href = href;
            }
        });
    })
});
