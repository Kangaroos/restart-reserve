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
});