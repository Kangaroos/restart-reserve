define(['jquery', 'dust', '$script'], function($, dust, $script){
    $('#main-sidebar').sidebar('attach events', '#sidebar-menu');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    var alertTmpl = require('../../../templates/admin/common/_alert.dust');

    $('#logoutAdminSystemBtn').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        dust.render(alertTmpl, {status: 'warning', desc: '确定要退出系统吗?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('.ui.basic.modal')
                .modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        location.href = href;
                        return false;
                    }
                })
                .modal('show');
        });
    })
});
