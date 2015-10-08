define(['jquery', 'dust', '$script'], function($, dust, $script) {
    var formTmpl = require('../../../../templates/admin/course/_form.dust');
    var alertTmpl = require('../../../../templates/admin/common/_alert.dust');
    var calendarTmpl = require('../../../../templates/admin/course/_calendar.dust');

    function formValid($form) {
        $form.form({
            on: 'blur',
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : 'Please enter your name'
                        }
                    ]
                }
            }
        });

        $form.on('submit', function(e) {
            e.preventDefault();
            if($(this).form('is valid')) {
                var data = $form.serialize();
                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: data,
                    dataType: 'json'
                }).done(function(ret){
                    if(ret.id) {
                        $('.ui.basic.modal').modal('hide');
                        window.location.reload();
                    } else {

                    }
                });
            }
        });
    }

    $('#createCourseBtn').on('click', function(e) {
        var formId = 'createCourseForm';
        $('.ui.modals').remove();
        dust.render(formTmpl, {
            formId: formId,
            header:'新增课程',
            saveText: '下一步',
            action: '/admin/courses',
            method: 'POST',
            stores: $.parseJSON($('#stores').val()),
            coaches: $.parseJSON($('#coaches').val()),
            modalId: 'createCourseModal'
        }, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            var classroomSelect = $('select[name="classroom_id"]');

            $('select[name="store_id"]').dropdown({
                action: function(text, value) {
                    $.ajax({
                        url: ['/admin/stores/', value, '/classrooms?is_select=1'].join(''),
                        type: 'GET',
                        dataType: 'json'
                    }).done(function(ret){
                        classroomSelect.empty();
                        $.each(ret, function(index, classroom) {
                            classroomSelect.append(['<option value="', classroom.id, '"', '>', classroom.name, '</option>'].join(''));
                        });
                        classroomSelect.dropdown('refresh');
                    });
                    $('select[name="store_id"]').dropdown('set selected', value);
                }
            });

            classroomSelect.dropdown();
            $('select[name="coach_id"]').dropdown();

            var $form = $('#' + formId);

            formValid($form);

            $('#createCourseModal').modal({
                closable  : false,
                allowMultiple: false,
                onDeny    : function(){
                },
                onApprove : function() {
                    dust.render(calendarTmpl, {
                        header:'设置课程时间',
                        saveText: '保 存',
                        backText: '上一步',
                        modalId: 'createCourseCalendarModal'
                    }, function(err, result) {
                        document.body.insertAdjacentHTML('beforeend', result);
                        $('#createCourseCalendarModal').modal({
                            closeable: false,
                            allowMultiple: false,
                            onDeny: function() {

                            },
                            onApprove : function() {

                            }
                        }).modal('show');
                    });
                    return false;
                }
            }).modal('show');
        });
    });

    $('div[data-id="deleteCourseBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),courseId = tr.data('id');
        $('.ui.basic.modals').remove();
        dust.render(alertTmpl, {status: 'warning', desc: '确定要删除课程信息?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
            document.body.insertAdjacentHTML('beforeend', result);
            $('.ui.basic.modal')
                .modal({
                    closable  : false,
                    onDeny    : function(){
                    },
                    onApprove : function() {
                        $.ajax({
                            url: ['/admin/courses/', courseId].join(''),
                            type: 'DELETE',
                            dataType: 'json'
                        }).done(function(ret){
                            $('.ui.basic.modal').modal('hide');
                            window.location.reload();
                        });
                        return false;
                    }
                })
                .modal('show');
        });
    });
});
