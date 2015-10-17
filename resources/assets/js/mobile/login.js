define(['jquery', 'dust', '$script'], function($, dust, $script){
    $('.members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });

    $('.non-members-tab').hammer().on('tap', function() {
        location.href = $(this).data('url');
    });
});
