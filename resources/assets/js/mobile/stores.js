define(['jquery', 'dust', '$script'], function($, dust, $script){


    $('.store').hammer().on('tap', function(){
        location.href = $(this).data('href');
    });


});
