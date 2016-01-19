define(['jquery', 'dust', '$script'], function($, dust, $script){
    require('../../../vendor/jQuery-Seat-Charts/_jquery.seat-charts.css');
    require('../../../vendor/jQuery-Seat-Charts/_jquery.seat-charts');

    var selectedSeats = $('#selected-seats');

    var seatMap = $('#seat-map');
    var seats = seatMap.data('seats');
    var align = 'center';
    if(seats.a.classes == 'triangle') {
        align = 'right';
    }

    var sc = seatMap.seatCharts({
        naming: {
            top: false,
            left:false
        },
        map: seatMap.data('map'),
        seats: seatMap.data('seats'),
        row: {
            align: align
        },
        legend : { //定义图例
            node : $('#legend'),
            items : [
                [ 'a', 'available',   '可选' ],
                [ 'a', 'unavailable', '已选']
            ]
        },
        click: function () { //点击事件
            if (this.status() == 'available') { //可选座
                if(selectedSeats.val() !== "") {
                    sc.get(selectedSeats.val()).status('available');
                }
                selectedSeats.val(this.settings.id);
                return 'selected';
            } else if (this.status() == 'selected') { //已选中
                $('#selected-seats').val('');
                return 'available';
            } else if (this.status() == 'unavailable') { //已售出
                return 'unavailable';
            } else {
                return this.style();
            }
        }
    });
    //已售出的座位
    sc.get(seatMap.data('unavailable')).status('unavailable');


    $('.btn-reserve').hammer().on('tap', function() {
        var $form = $('form');

        if($('#selected-seats').val() == "") {
            sweetAlert("出错啦...", "请选择一个位子", "error");
            return;
        }

        $form.submit();
    });

    var $errorMsg = $('#errorMsg');
    if($errorMsg.val() != 0) {
        sweetAlert("出错啦...", $errorMsg.val(), "error");
        setTimeout(function(){
            location.href = $('#redirectUrl').val();
        }, 3000);
    }
});
