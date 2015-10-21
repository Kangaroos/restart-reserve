define(['jquery', 'dust', '$script'], function($, dust, $script){

    $('.date-tab .item').hammer().on('tap', function() {
        $('.date-tab .item').removeClass('active');
        $(this).addClass('active');
        var className = $(this).data('class');
        $('.today').removeClass('show');
        $('.tomorrow').removeClass('show');
        $('.day-after-tomorrow').removeClass('show');
        $(className).addClass('show');
    });
});
