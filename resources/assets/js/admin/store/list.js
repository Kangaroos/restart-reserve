define(['jquery', 'dust', '$script'], function($, dust, $script){
    $('.special.cards .image').dimmer({
        on: 'hover'
    });

    var formTmpl = require('../../../../templates/admin/store/_form.dust');
    var alertTmpl = require('../../../../templates/admin/common/_alert.dust');

    function formValid($form) {
        $form.form({
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : 'Please enter your name'
                        }
                    ]
                },
                mobile: {
                    identifier: 'mobile',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : 'Please enter your mobile'
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

    $('#createStoreBtn').on('click', function(e) {
        var formId = 'createStoreForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增门店',
            saveText: '保 存',
            action: '/admin/stores',
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

    $('div[data-id="editStoreBtn"]').on('click', function(e) {
        var formId = 'editStoreForm';
        var card = $(this).closest('.ui.card'), storeId = card.data('id');

        $('.ui.modals').remove();

        $.ajax({
            url: ['/admin/stores/',storeId].join(''),
            type: 'GET',
            dataType: 'json'
        }).done(function(ret) {
            var renderData = $.extend({
                formId: formId,
                header:'修改门店',
                saveText: '更 新',
                action: ['/admin/stores/', storeId].join(''),
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

    $('div[data-id="updateCoverBtn"]').on('click', function(e) {
        $(this).closest('.ui.card').find('.cover-upload-input').trigger('click',e);
    });

    $('div[data-id="deleteStoreBtn"]').on('click', function(e) {
        var card = $(this).closest('.ui.card'),storeId = card.data('id');
        $('.ui.basic.modals').remove();
        dust.render(alertTmpl, {status: 'warning', desc: '确定要删除门店信息?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('.ui.basic.modal')
                .modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        $.ajax({
                            url: ['/admin/stores/', storeId].join(''),
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

    $('.cover-upload-input').on('change', function(){
        var card = $(this).closest('.ui.card'),storeId = card.data('id'), image = card.find('.cover-image');
        var file = this.files[0];
        var type = $.trim(file.type);
        if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
            || ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )
        ) {
            alert('请选择正确的图片')
        } else {
            $('.ui.basic.modals').remove();
            dust.render(alertTmpl, {status: 'warning', desc: '确定要替换封面吗?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
                document.body.insertAdjacentHTML('beforeend', result);
                $('.ui.basic.modal')
                    .modal({
                        closable  : false,
                        onDeny    : function(){
                        },
                        onApprove : function() {
                            var data = new FormData();
                            data.append('cover', file);
                            $.ajax({
                                url: ['/admin/stores/cover/', storeId].join(''),
                                type: 'POST',
                                data: data,
                                processData: false,
                                contentType: false
                            }).done(function(ret){
                                $('.ui.basic.modal').modal('hide');
                                window.location.reload();
                            });
                            return false;
                        }
                    })
                    .modal('show');
            });
        }
    });



});
