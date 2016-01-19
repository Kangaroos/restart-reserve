define(['jquery', 'dust', '$script'], function($, dust, $script){

    var sendSmsData = $.parseJSON($('.sms-form').serializeObject());

    $('#qrcode').qrcode(sendSmsData.order_no);

    $('.cancel-reserve').on('click', function(e) {
        swal({
            title: "提示",
            text: "是否取消预约课程?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/reserves/' + $('#reserveId').val() + "/cancel",
                    method: 'PUT',
                    dataType: 'json'
                }).done(function(ret) {
                    swal.close();
                    location.href = "/members/reserve";
                }).fail(function() {
                    sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                });
            }
        });
    });

    $('.send-otp').on('click', function() {
        if($('.send-otp').attr('disabled')) {
            return;
        }
        $.ajax({
            url: '/reserves/send',
            method: 'POST',
            dataType: 'json',
            data: sendSmsData
        }).done(function(ret) {
            $('.send-otp').attr('disabled', true);
            sweetAlert("提示...", "短信发送成功", "info");
        });
    });
});
