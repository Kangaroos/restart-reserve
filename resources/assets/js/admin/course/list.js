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
        var formId = 'createCourseForm';
        $('.ui.modals').remove();

        dust.render(formTmpl, {
            formId: formId,
            header:'新增课程',
            saveText: '保 存',
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
                    if(formValid($form)) {
                        var dataStr = $form.serializeObject();
                        $.ajax({
                            url: $form.attr('action'),
                            method: $form.attr('method'),
                            dataType: 'json',
                            data: $form.serialize()
                        }).done(function(ret) {
                            createCourseModal.modal('hide');
                            window.location.reload();
                        }).fail(function() {
                            sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                        });
                    }
                    return false;
                }
            }).modal('show');
        });

    });

    $('div[data-id="editCourseBtn"]').on('click', function(e) {
        var formId = 'editCourseForm';
        var tr = $(this).closest('tr'),courseId = tr.data('id');
        $('.ui.modals').remove();
        $('#loading').addClass('active');

        dust.render(formTmpl, {
            formId: formId,
            header:'修改课程',
            saveText: '保 存',
            action: '/admin/courses/' + courseId,
            method: 'PUT',
            id: courseId,
            stores: $.parseJSON($('#stores').val()),
            coaches: $.parseJSON($('#coaches').val()),
            modalId: 'editCourseModal'
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
                        $('select[name="store_id"]').trigger('subSelectLoaded');
                    });
                    $('select[name="store_id"]').dropdown('set selected', value);
                }
            });



            var $form = $('#' + formId);

            $.getJSON('/admin/courses/' + courseId,{}, function(data){
                var editCourseModal = $('#editCourseModal');
                editCourseModal.find('input[name="name"]').val(data.name);

                //$('select[name="store_id"]').dropdown('set selected',data.store_id);
                $('select[name="store_id"]').dropdown('get item', data.store_id)[0].trigger('click');

                $('select[name="store_id"]').on('subSelectLoaded', function(classRoomId){
                    return function() {
                        classroomSelect.dropdown('set selected',classRoomId);
                    }
                }(data.classroom_id));

                $('select[name="coach_id"]').dropdown('set selected', data.coach_id);
                editCourseModal.find('input[name="class_time_begin"]').val(data.class_time_begin);
                editCourseModal.find('input[name="class_time_end"]').val(data.class_time_end);
                editCourseModal.find('textarea[name="description"]').val(data.description);
                editCourseModal.find('textarea[name="needing_attention"]').val(data.needing_attention);

                $('#loading').removeClass('active');
                editCourseModal.modal({
                    closable  : false,
                    allowMultiple: false,
                    onDeny    : function(){
                        editCourseModal.modal('show');
                    },
                    onApprove : function() {
                        if(formValid($form)) {
                            $.ajax({
                                url: $form.attr('action'),
                                method: $form.attr('method'),
                                dataType: 'json',
                                data: $form.serialize()
                            }).done(function(ret) {
                                editCourseModal.modal('hide');
                                window.location.reload();
                            }).fail(function() {
                                sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                            });
                        }
                        return false;
                    }
                }).modal('show');
            });
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

    $('div[data-id="publishCourseBtn"]').on('click', function(e) {
        var tr = $(this).closest('tr'),courseId = tr.data('id');
        $('.ui.modals').remove();
        var events = [];
        $('#loading').addClass('active');
        $.getJSON('/admin/courses/' + courseId,{}, function(data){
            $(data.schedules).each(function(i, schedule){
                var event = {};
                event.schedule_id = schedule.id;
                event.title = data.name;
                event.start = schedule.class_date + " " + data.class_time_begin;
                event.end = schedule.class_date + " " + data.class_time_end;
                event.stick = true;
                events.push(event);
            });

            dust.render(calendarTmpl, {
                header:'发布课程',
                backText: '关 闭',
                modalId: 'createCourseCalendarModal',
                name: data.name
            }, function(err, result) {
                document.body.insertAdjacentHTML('beforeend', result);

                var course = $('.drag-course');
                course.data('event', {
                    start: data.class_time_begin,
                    end: data.class_time_end,
                    title: data.name,
                    stick: true
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

                var createCourseCalendarModal = $('#createCourseCalendarModal');

                createCourseCalendarModal.modal({
                    closeable: false,
                    allowMultiple: false,
                    onDeny: function() {
                        createCourseCalendarModal.modal("show");
                    },
                    onVisible: function() {

                        $('#loading').removeClass('active');

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
                            events: events,
                            eventClick: function(event, jsEvent, view) {
                                swal({
                                    title: "提示",
                                    text: "确定要删除 "+ event.start.format('YYYY-MM-DD') + " " + event.title + "课程?",
                                    type: "warning",
                                    showCancelButton: true,
                                    closeOnConfirm: false,
                                    showLoaderOnConfirm: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "确认",
                                    cancelButtonText: "取消"
                                }, function(isConfirm) {
                                    if (isConfirm) {
                                        $.ajax({
                                            url: '/admin/courses/schedules/' + event.schedule_id,
                                            method: 'DELETE',
                                            dataType: 'json'
                                        }).done(function(ret) {
                                            swal.close();
                                            $('#calendar').fullCalendar( 'removeEvents' , event._id );
                                        }).fail(function() {
                                            sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                                        });
                                    }
                                });
                            },
                            eventReceive: function( event ) {
                                var courseSchedule = $.extend({},data);
                                courseSchedule.class_date = event.start.format('YYYY-MM-DD');

                                $.getJSON( '/admin/course/check', courseSchedule, function( ret ) {
                                    return function(ret, event){
                                        if(ret.status) {
                                            $.ajax({
                                                url: '/admin/courses/'+ courseId +'/schedules',
                                                method: 'post',
                                                dataType: 'json',
                                                data: {
                                                    'class_date': event.start.format('YYYY-MM-DD'),
                                                    'week': event.start.format('dddd')
                                                }
                                            }).done(function(ret) {
                                                event.schedule_id = ret;
                                            }).fail(function() {
                                                sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                                            });
                                        } else {
                                            sweetAlert("出错啦...", "该教室该时间段已经有人在上课了!", "error");
                                            $('#calendar').fullCalendar( 'removeEvents' , event._id );
                                        }
                                    }(ret, event)
                                });
                            },
                            eventDrop: function(event, delta, revertFunc) {
                                var courseSchedule = $.extend({}, data);
                                courseSchedule.class_date = event.start.format('YYYY-MM-DD');

                                $.getJSON( '/admin/course/check', courseSchedule, function( ret ) {
                                    if(ret.status) {
                                        $.ajax({
                                            url: '/admin/courses/schedules/' + event.schedule_id,
                                            method: 'put',
                                            dataType: 'json',
                                            data: {
                                                'class_date': event.start.format('YYYY-MM-DD'),
                                                'week': event.start.format('dddd')
                                            }
                                        }).done(function(ret) {
                                        }).fail(function() {
                                            sweetAlert("出错啦...", "服务器君偷懒了，快去找管理员来修理他...", "error");
                                        });
                                    } else {
                                        sweetAlert("出错啦...", "该教室该时间段已经有人在上课了!", "error");
                                        revertFunc();
                                    }
                                });
                            }
                        });
                        $(this).modal('refresh');
                    }
                }).modal('show');
            });
        });
    });
});
