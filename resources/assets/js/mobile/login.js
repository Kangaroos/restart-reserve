define(['jquery', 'dust', '$script', '../vendor/_jquery.laravel-sms'], function($, dust, $script){

    $('.members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });

    $('.non-members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });

    $('#postFormBtn').hammer().on('tap', function(e) {
        var $form = $('form');
        var cardNumber = $('input[name=card_number]').val();
        if(!/^[A-Za-z]{2}[0-9]{6}$/i.test(cardNumber)) {
            sweetAlert("出错啦...", "会员卡号格式不正确", "error");
            return;
        }

        if($('input[name=name]').val() == "") {
            sweetAlert("出错啦...", "姓名不能为空", "error");
            return;
        }

        if($('input[name=mobile]').val() == "") {
            sweetAlert("出错啦...", "手机号码不能为空", "error");
            return;
        }

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method'),
            dataType: 'json',
            data: $form.serialize()
        }).done(function(data){
            if(data.success) {
                location.href = data.redirectTo;
            } else {
                sweetAlert("友情提示", data.error, "info");
            }
        }).fail(function( jqXHR, textStatus, errorThrown) {
            var ret = $.parseJSON(jqXHR.responseText);
            if(ret.mobile && ret.mobile[0] == 'validation.mobile_changed') {
                sweetAlert("出错啦...", "短信码不正确", "error");
                return;
            } else if((ret.verifyCode && ret.verifyCode[0] == 'validation.verify_code_mock') || (ret.verifyCode && ret.verifyCode[1] == 'validation.verify_rule')) {
                sweetAlert("出错啦...", "短信码不正确", "error");
                return;
            }
            $.each(ret, function(key , value) {
                $.each(value, function(error, msg) {
                    sweetAlert("出错啦...", msg, "error");
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
            sweetAlert("出错啦...", msg, "error");
        }
    });
});
