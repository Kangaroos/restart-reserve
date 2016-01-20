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

    var formTmpl = require('../../../templates/admin/_pwdform.dust');

    $('#changePwdBtn').on('click', function(e){
        $('.ui.modals').remove();

        dust.render(formTmpl, {
            header:'修改密码',
            saveText: '更 新',
            backText: '关 闭',
            modalId: 'changePwdModal'
        }, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);

            var changePwdModal = $('#changePwdModal');

            changePwdModal.modal({
                closeable: false,
                allowMultiple: false,
                onDeny: function() {
                    changePwdModal.modal("show");
                },
                onApprove : function() {
                    var password = $('#changePwdInput').val();
                    if(password == "") {
                        sweetAlert("出错啦...", "密码不能为空", "error");
                        return false;
                    }
                    $.ajax({
                        url: '/admin/changePwd',
                        method: 'PUT',
                        dataType: 'json',
                        data: {
                            password: password
                        }
                    }).done(function(ret) {
                        changePwdModal.modal('hide');

                    }).fail(function() {
                        sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                    });
                    return false;
                }
            }).modal('show');
        });
    });

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
