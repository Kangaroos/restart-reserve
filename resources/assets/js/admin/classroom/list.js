define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/classroom/_form.dust');
    var alertTmpl = require('../../../../templates/admin/common/_alert.dust');

    function formValid($form) {
        $form.form({
            //on: 'blur',
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : 'Please enter your name'
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
        $('.ui.basic.modals').remove();
        dust.render(alertTmpl, {status: 'warning', desc: '确定要删除教室信息?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('.ui.basic.modal')
                .modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        $.ajax({
                            url: ['/admin/classrooms/', classroomId].join(''),
                            type: 'DELETE',
                            dataType: 'json'
                        }).done(function(ret){
                            $('.ui.basic.modal').modal('hide');
                            window.location.reload();
                        });
                        return false;
                    }
                })
                .modal('show');
        });
    });
});
