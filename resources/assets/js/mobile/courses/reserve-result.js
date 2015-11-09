define(['jquery', 'dust', '$script'], function($, dust, $script){

    require('../../components/_toasts');

    var sendSmsData = $.parseJSON($('.sms-form').serializeObject());

    $('#qrcode').qrcode(sendSmsData.order_no);

    $('.send-otp').hammer().on('tap', function() {
        if($('.send-otp').attr('disabled')) {
            return;
        }
        $.ajax({
            url: '/reserves/send',
            method: 'POST',
            dataType: 'json',
            data: sendSmsData
        }).done(function(ret) {
            console.log(ret);
            $('.send-otp').attr('disabled', true);
            Materialize.toast('短信发送成功！', 3000);
        });
    });
});
