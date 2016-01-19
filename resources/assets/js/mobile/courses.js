define(['jquery', 'dust', '$script'], function($, dust, $script){

    $('.date-tab .item').on('click', function() {
        $('.date-tab .item').removeClass('active');
        $(this).addClass('active');
        var className = $(this).data('class');
        $('.today').removeClass('show');
        $('.tomorrow').removeClass('show');
        $('.day-after-tomorrow').removeClass('show');
        $(className).addClass('show');
    });

    var detailTmpl = require('../../../templates/mobile/courses/_detail.dust');

    $('.course .button.detail').on('click', function(e) {
        var courseDetail = $('.course-detail');
        if(courseDetail.length > 0) {
            courseDetail.remove();
        }

        var course = $(this).data('course');
        course.coach = $(this).data('coach');

        dust.render(detailTmpl, course, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);

            $('.course-detail .close-icon').on('click', function() {
                $('.course-detail').remove();
            })
        });
    })
});
