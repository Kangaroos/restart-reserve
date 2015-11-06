define(['jquery', 'dust', '$script'], function($, dust, $script){
    require('../../../vendor/jQuery-Seat-Charts/_jquery.seat-charts.css');
    require('../../../vendor/jQuery-Seat-Charts/_jquery.seat-charts');

    var selectedSeats = $('#selected-seats');
    var sc = $('#seat-map').seatCharts({
        naming: {
            top: false,
            left:false
        },
        map: ['aaaaaaa','aaaaaaa','aaaaaaa','aaaaaaa','_aaaaaa','__aaaaa'],
        seats: {a: {classes : 'triangle'}},
        row: {
            align: 'right'
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
    sc.get(['1_1']).status('unavailable');
});
