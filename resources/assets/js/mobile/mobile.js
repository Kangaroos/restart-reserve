define(['jquery', '$script', '../vendor/_jquery.hammer'], function($, $script){
    $script([
        '//cdn.bootcss.com/jquery-easing/1.3/jquery.easing.min.js'
        ,'//cdn.bootcss.com/velocity/1.2.3/velocity.min.js'
    ], 'material',
    function(){
        require('../components/_global');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.fn.serializeObject = function () {
        var obj = {};
        var count = 0;
        $.each(this.serializeArray(), function (i, o) {
            var n = o.name, v = o.value;
            count++;
            obj[n] = obj[n] === undefined ? v
                : $.isArray(obj[n]) ? obj[n].concat(v)
                : [obj[n], v];
        });
        return JSON.stringify(obj);
    };
});