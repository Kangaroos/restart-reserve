define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/coach/_form.dust');
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
        $('.ui.basic.modals').remove();
        dust.render(alertTmpl, {status: 'warning', desc: '确定要删除教练信息?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('.ui.basic.modal')
                .modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        $.ajax({
                            url: ['/admin/coaches/', coachId].join(''),
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
