define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/classroom/_form.dust');

    function formValid($form) {
        $form.form({
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入教室名称'
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

    $('#createClassroomBtn').on('click', function(e) {
        var formId = 'createClassroomForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增教室',
            saveText: '保 存',
            action: '/admin/classrooms',
            method: 'POST',
            stores: $.parseJSON($('#stores').val())
        }, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('select.dropdown').dropdown();

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

    $('div[data-id="editClassroomBtn"]').on('click', function(e) {
        var formId = 'editClassroomForm';
        var tr = $(this).closest('tr'), classroomId = tr.data('id');

        $('.ui.modals').remove();

        $.ajax({
            url: ['/admin/classrooms/',classroomId].join(''),
            type: 'GET',
            dataType: 'json'
        }).done(function(ret) {
            var renderData = $.extend({
                formId: formId,
                header:'修改教室',
                saveText: '更 新',
                action: ['/admin/classrooms/', classroomId].join(''),
                method: 'PUT',
                stores: $.parseJSON($('#stores').val())
            }, ret);

            dust.render(formTmpl, renderData, function(err, result) {
                document.body.insertAdjacentHTML('beforeend', result);

                var $form = $('#' + formId);
                $('select[name=store_id]').dropdown('set selected', ret.store_id);
                $('select[name=seats_style]').dropdown('set selected', $.parseJSON(ret.seats, true).a.classes);
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

    $('div[data-id="deleteClassroomBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),classroomId = tr.data('id');
        swal({
            title: "提示",
            text: "确定要删除教室信息?",
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
                    url: ['/admin/classrooms/', classroomId].join(''),
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
