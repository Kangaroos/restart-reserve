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

    var detailTmpl = require('../../../templates/mobile/courses/_detail.dust');

    $('.course .button.detail').hammer().on('tap', function(e) {
        var courseDetail = $('.course-detail');
        if(courseDetail.length > 0) {
            courseDetail.remove();
        }

        dust.render(detailTmpl, {}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);

            $('.course-detail .close-icon').hammer().on('tap', function() {
                $('.course-detail').remove();
            })
        });
    })
});
