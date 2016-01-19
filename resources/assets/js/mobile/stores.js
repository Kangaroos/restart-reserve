define(['jquery', 'dust', '$script'], function($, dust, $script){


    $('.store').on('click', function(){
        location.href = $(this).data('href');
    });


});
