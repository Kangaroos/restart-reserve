define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/role/_form.dust');

    function formValid($form) {
        $form.form({
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入角色名称'
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

    $('#createRoleBtn').on('click', function(e) {
        var formId = 'createRoleForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增角色',
            saveText: '保 存',
            action: '/admin/roles',
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

    $('div[data-id="editRoleBtn"]').on('click', function(e) {
        var formId = 'editRoleForm';
        var tr = $(this).closest('tr'), roleId = tr.data('id');

        $('.ui.modals').remove();

        $.ajax({
            url: ['/admin/roles/',roleId].join(''),
            type: 'GET',
            dataType: 'json'
        }).done(function(ret) {
            var renderData = $.extend({
                formId: formId,
                header:'修改角色',
                saveText: '更 新',
                action: ['/admin/roles/', roleId].join(''),
                method: 'PUT'
            }, ret);

            dust.render(formTmpl, renderData, function(err, result) {
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
    });

    $('div[data-id="deleteRoleBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),roleId = tr.data('id');

        swal({
            title: "提示",
            text: "确定要删除角色信息?",
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
                    url: ['/admin/roles/', roleId].join(''),
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

});
