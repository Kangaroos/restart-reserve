define(['jquery', 'dust', '$script', '../vendor/_jquery.laravel-sms'], function($, dust, $script){
    require('../components/_toasts');

    $('.members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });

    $('.non-members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });

    $('#postFormBtn').hammer().on('tap', function(e) {
        var $form = $('form');
        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            dataType: 'json',
            data: $form.serialize()
        }).done(function(data){
            if(data.success) {
                location.href = data.redirectTo;
            }
        }).fail(function( jqXHR, textStatus, errorThrown) {
            var ret = $.parseJSON(jqXHR.responseText);
            if(ret.mobile && ret.mobile[0] == 'validation.mobile_changed') {
                Materialize.toast('短信码不正确', 3000);
                return;
            } else if((ret.verifyCode && ret.verifyCode[0] == 'validation.verify_code_mock') || (ret.verifyCode && ret.verifyCode[1] == 'validation.verify_rule')) {
                Materialize.toast('短信码不正确', 3000);
                return;
            }
            $.each(ret, function(key , value) {
                $.each(value, function(error, msg) {
                    Materialize.toast(msg, 3000);
                })
            });
        });
    });

    $('#sendVerifySmsButton').sms({
        //定义如何获取mobile的值
        mobileSelector : 'input[name="mobile"]',
        //定义手机号的检测规则,当然你还可以到配置文件中自定义你想要的任何规则
        mobileRule     : 'check_mobile',
        //是否请求语音验证码
        voice          : false,
        //定义服务器有消息返回时如何展示，默认为alert
        alertMsg       :  function (msg, type) {
            Materialize.toast(msg, 3000);
        }
    });
});
