define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/coach/_form.dust');

    function formValid($form) {
        $form.form({
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入教练名称'
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

    $('#createCoachBtn').on('click', function(e) {
        var formId = 'createCoachForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增教练',
            saveText: '保 存',
            action: '/admin/coaches',
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

    $('div[data-id="editCoachBtn"]').on('click', function(e) {
        var formId = 'editCoachForm';
        var tr = $(this).closest('tr'), coachId = tr.data('id');

        $('.ui.modals').remove();

        $.ajax({
            url: ['/admin/coaches/',coachId].join(''),
            type: 'GET',
            dataType: 'json'
        }).done(function(ret) {
            var renderData = $.extend({
                formId: formId,
                header:'修改教练',
                saveText: '更 新',
                action: ['/admin/coaches/', coachId].join(''),
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

    $('div[data-id="deleteCoachBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),coachId = tr.data('id');

        swal({
            title: "提示",
            text: "确定要删除教练信息?",
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
                    url: ['/admin/coaches/', coachId].join(''),
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

    $('#exportCoachBtn').on('click', function(e) {
        swal({
            title: "提示",
            text: "确定导出所有教练数据?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                window.open('/admin/coaches/export');
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
