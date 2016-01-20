define(['jquery', 'dust', '$script'], function($, dust, $script) {
    $('#reserveTab .item').tab();

    $('div[data-id="deleteReserveBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),reserveId = tr.data('id');
        swal({
            title: "提示",
            text: "确定要删除预约信息?",
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
                    url: ['/admin/reserves/', reserveId].join(''),
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

    $('div[data-id="cancelReserveBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),reserveId = tr.data('id');
        swal({
            title: "提示",
            text: "确定要取消预约?",
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
                    url: ['/admin/reserves/', reserveId].join(''),
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        status: 'cancel'
                    }
                }).done(function(ret){
                    swal({
                        title: "取消成功",
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


    $('div[data-id="verifyReserveBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),reserveId = tr.data('id');
        swal({
            title: "预订核销",
            text: "请输入核销码:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            animation: "slide-from-top",
            inputPlaceholder: "请输入核销码"
        }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("请输入核销码!");
                return false;
            }

            $.ajax({
                url: ['/admin/reserves/', reserveId, '/verify'].join(''),
                type: 'PUT',
                dataType: 'json',
                data: {
                    order_no: inputValue
                }
            }).done(function(ret){
                if(ret.error) {
                    sweetAlert("错误提示", ret.error, "error");
                    return;
                }
                swal({
                    title: "核销成功",
                    text: "1 秒后返回...",
                    timer: 1000,
                    showConfirmButton: false
                }, function() {
                    window.location.reload();
                });
            });


        });
    });


});
