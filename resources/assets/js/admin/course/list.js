define(['jquery', 'dust', '$script', 'moment'], function($, dust, $script, moment) {
    var formTmpl = require('../../../../templates/admin/course/_form.dust');
    var calendarTmpl = require('../../../../templates/admin/course/_calendar.dust');

    require('../../../vendor/jquery-ui-1.11.4.custom/_jquery-ui');
    function formValid($form) {
        $form.form({
            //on: 'blur',
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入课程名称'
                        }
                    ]
                },
                store_id: {
                    identifier: 'store_id',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请选择门店'
                        }
                    ]
                },
                classroom_id: {
                    identifier: 'classroom_id',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请选择教室'
                        }
                    ]
                },
                coach_id: {
                    identifier: 'coach_id',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请选择教练'
                        }
                    ]
                },
                class_time_begin: {
                    identifier: 'class_time_begin',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请选择课程开始时间'
                        }
                    ]
                },
                class_time_end: {
                    identifier: 'class_time_end',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请选择课程结束时间'
                        }
                    ]
                }
            }
        });

        return $form.form('is valid');
    }

    $('#createCourseBtn').on('click', function(e) {
        var formId = 'createCourseForm', submitData = [];
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

            $('input[name="class_time_begin"]').timepicker({
                'showDuration': true,
                'timeFormat': 'H:i',
                closeOnWindowScroll: true,
                disableTextInput: true,
                disableTouchKeyboard: true,
                show2400: true,
                step: 15,
                scrollDefault: 'now',
                disableTimeRanges: ['23:00', '06:00']
            });

            $('input[name="class_time_end"]').timepicker({
                'showDuration': true,
                'timeFormat': 'H:i',
                closeOnWindowScroll: true,
                disableTextInput: true,
                disableTouchKeyboard: true,
                show2400: true,
                step: 15,
                scrollDefault: 'now',
                disableTimeRanges: ['23:00', '06:00']
            });

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

            var createCourseModal = $('#createCourseModal');

            createCourseModal.modal({
                closable  : false,
                allowMultiple: false,
                onDeny    : function(){
                    createCourseModal.modal('show');
                },
                onApprove : function() {
                    var createCourseCalendarModal = $('#createCourseCalendarModal');
                    if(createCourseCalendarModal.length) {
                        createCourseCalendarModal.modal('show');
                    } else {
                        if(formValid($form)) {
                            var dataStr = $form.serializeObject(), data = $.parseJSON(dataStr);
                            dust.render(calendarTmpl, {
                                header:'设置课程时间',
                                saveText: '保 存',
                                backText: '上一步',
                                modalId: 'createCourseCalendarModal',
                                name: data.name
                            }, function(err, result) {
                                document.body.insertAdjacentHTML('beforeend', result);
                                var course = $('.drag-course');
                                course.data('event', {
                                    start: data.class_time_begin,
                                    end: data.class_time_end,
                                    title: data.name, // use the element's text as the event title
                                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                                });

                                course.draggable({
                                    zIndex: 999,
                                    revert: true,      // will cause the event to go back to its
                                    revertDuration: 0  //  original position after the drag
                                });

                                course.popup({
                                    title   : '课程名称：' + data.name,
                                    content : '课程时间：' + data.class_time_begin + '-' + data.class_time_end
                                });

                                $('#createCourseCalendarModal').modal({
                                    closeable: false,
                                    allowMultiple: false,
                                    onDeny: function() {
                                        createCourseModal.modal('show');
                                    },
                                    onApprove : function() {
                                        $.ajax({
                                            url: $form.attr('action'),
                                            method: $form.attr('method'),
                                            dataType: 'json',
                                            data: {
                                                'courses':  JSON.stringify(submitData)
                                            }
                                        }).done(function(ret) {
                                            $('#createCourseCalendarModal').modal('hide');
                                            window.location.reload();
                                        }).fail(function() {
                                            sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                                        });
                                        return false;
                                    },
                                    onVisible: function() {
                                        $('#calendar').fullCalendar({
                                            header: {
                                                left: 'prev,next today',
                                                center: 'title',
                                                right: 'month'
                                            },
                                            editable: true,
                                            eventLimit: true,
                                            slotEventOverlap: false,
                                            eventOverlap: false,
                                            slotDuration: '00:15:00',
                                            timeFormat: 'H:mm',
                                            eventDurationEditable: false,
                                            droppable: true,
                                            currentTimezone: 'Asia/Beijing',
                                            eventClick: function(event, jsEvent, view) {

                                            },
                                            drop: function(date, jsEvent, ui) {
                                                //$(this).remove();
                                                return false;
                                            },
                                            eventReceive: function( event ) {
                                                var course = $.extend({},data);
                                                course.class_date = event.start.format('YYYY-MM-DD');
                                                course.week = event.start.format('dddd');
                                                course._id = event._id;

                                                $.getJSON( '/admin/course/check', course, function( ret ) {
                                                    return function(ret, event){
                                                        if(ret.status) {
                                                            submitData.push(course);
                                                        } else {
                                                            sweetAlert("出错啦...", "该教室该时间段已经有人在上课了!", "error");
                                                            $('#calendar').fullCalendar( 'removeEvents' ,ret.id );
                                                        }
                                                    }(ret, event)
                                                });
                                            },
                                            eventDrop: function(event, delta, revertFunc) {
                                                $.each(submitData, function(index, obj) {
                                                    return function(index, obj, event, revertFunc) {
                                                        if(submitData[index]._id === event._id) {
                                                            var course = $.extend({},submitData[index]);
                                                            course.class_date = event.start.format('YYYY-MM-DD');
                                                            course.week = event.start.format('dddd');

                                                            $.getJSON( '/admin/course/check', course, function( ret ) {
                                                                if(ret.status) {
                                                                    submitData[index].class_date = event.start.format('YYYY-MM-DD');
                                                                    submitData[index].week = event.start.format('dddd');
                                                                } else {
                                                                    sweetAlert("出错啦...", "该教室该时间段已经有人在上课了!", "error");
                                                                    revertFunc();
                                                                }
                                                            });
                                                        }
                                                    }(index, obj, event, revertFunc)
                                                });
                                            }
                                        });
                                        $(this).modal('refresh');
                                    }
                                }).modal('show');
                            });
                        }
                    }
                    return false;
                }
            }).modal('show');
        });



    });

    $('div[data-id="deleteCourseBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),courseId = tr.data('id');
        swal({
            title: "提示",
            text: "确定要删除课程信息?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: "取消"
        }, function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: ['/admin/courses/', courseId].join(''),
                    type: 'DELETE',
                    dataType: 'json'
                }).done(function(ret){
                    swal({
                        title: "删除成功",
                        text: "1 秒后返回...",
                        timer: 1000,
                        showConfirmButton: false
                    }, function() {
                        window.location.reload();
                    });
                });
            }
        });
    });
});
