define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/user/_form.dust');
    $('#userTab .item').tab();
    function formValid($form) {
        $form.form({
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入用户名称'
                        }
                    ]
                }
            }
        });

        $form.on('submit', function(e) {
            e.preventDefault();
            if($(this).form('is valid')) {
                var data = $form.serialize();
                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: data,
                    dataType: 'json'
                }).done(function(ret){
                    if(ret.id) {
                        $('.ui.basic.modal').modal('hide');
                        window.location.reload();
                    } else {

                    }
                });
            }
        });
    }

    $('#createUserBtn').on('click', function(e) {
        var formId = 'createUserForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增用户',
            saveText: '保 存',
            action: '/admin/users',
            method: 'POST'
        }, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);

            var $form = $('#' + formId);
            formValid($form);

            $('.ui.modal').modal({
                closable  : false,
                onDeny    : function(){
                },
                onApprove : function() {
                    $form.trigger('submit');
                    return false;
                }
            }).modal('show');
        });
    });

    $('div[data-id="editUserBtn"]').on('click', function(e) {
        var formId = 'editUserForm';
        var tr = $(this).closest('tr'), userId = tr.data('id');

        $('.ui.modals').remove();

        $.ajax({
            url: ['/admin/users/',userId].join(''),
            type: 'GET',
            dataType: 'json'
        }).done(function(ret) {
            var renderData = $.extend({
                formId: formId,
                header:'修改用户',
                saveText: '更 新',
                action: ['/admin/users/', userId].join(''),
                method: 'PUT'
            }, ret);

            dust.render(formTmpl, renderData, function(err, result) {
                document.body.insertAdjacentHTML('beforeend', result);

                var $form = $('#' + formId);

                formValid($form);
                $('select[name=level]').dropdown('set selected', ret.level);
                $('.ui.modal').modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        $form.trigger('submit');
                        return false;
                    }
                }).modal('show');
            });
        });
    });


    $('div[data-id="auditUserBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'), userId = tr.data('id');

        swal({
            title: "提示",
            text: "是否通过审核?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: ['/admin/users/',userId, '/audit'].join(''),
                    type: 'PUT',
                    dataType: 'json'
                }).done(function(ret) {
                    window.location.reload();
                });
            }
        });


    });

    $('div[data-id="deleteUserBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),userId = tr.data('id');

        swal({
            title: "提示",
            text: "确定要删除用户信息?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: ['/admin/users/', userId].join(''),
                    type: 'DELETE',
                    dataType: 'json'
                }).done(function(ret){
                    swal({
                        title: "删除成功",
                        text: "1 秒后返回...",
                        timer: 1000,
                        showConfirmButton: false
                    }, function() {
                        window.location.reload();
                    });
                });
            }
        });
    });

    $('#exportUserBtn').on('click', function(e) {
        swal({
            title: "提示",
            text: "确定导出所有会员数据?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                window.open('/admin/users/export');
                swal({
                    title: "导出成功",
                    text: "1 秒后返回...",
                    timer: 1000,
                    showConfirmButton: false
                }, function() {
                    window.location.reload();
                });
            }
        });
    });

});
