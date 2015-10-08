/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/assets/webpack/";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(1), __webpack_require__(2), __webpack_require__(3)], __WEBPACK_AMD_DEFINE_RESULT__ = function($, dust, $script) {
	    var formTmpl = __webpack_require__(7);
	    var alertTmpl = __webpack_require__(5);
	    var calendarTmpl = __webpack_require__(8);

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

	        var createCourseModal = $('#createCourseModal'), createCourseCalendarModal = $('#createCourseCalendarModal');

	        if(createCourseModal.length) {
	            createCourseModal.modal('show');
	        } else {
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

	                        if(createCourseCalendarModal.length) {
	                            createCourseCalendarModal.modal('show');
	                        } else {
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
	                                        createCourseModal.modal('show');
	                                    },
	                                    onApprove : function() {

	                                    }
	                                }).modal('show');
	                            });
	                        }
	                        return false;
	                    }
	                }).modal('show');
	            });
	        }


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
	}.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));


/***/ },
/* 1 */
/***/ function(module, exports) {

	module.exports = jQuery;

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = dust;

/***/ },
/* 3 */
/***/ function(module, exports) {

	module.exports = $script;

/***/ },
/* 4 */,
/* 5 */
/***/ function(module, exports) {

	module.exports = (function(dust){dust.register("resources\/templates\/admin\/common\/_alert",body_0);function body_0(chk,ctx){return chk.w("<div class=\"ui small basic modal\"><div class=\"ui icon header\"><i class=\"").f(ctx.get(["status"], false),ctx,"h").w(" circle icon\"></i>").f(ctx.get(["desc"], false),ctx,"h").w("</div><div class=\"actions\"><div class=\"ui red deny basic inverted button\"><i class=\"remove icon\"></i>").f(ctx.get(["denyButtonText"], false),ctx,"h").w("</div><div class=\"ui green approve basic inverted button\"><i class=\"checkmark icon\"></i>").f(ctx.get(["confirmButtonText"], false),ctx,"h").w("</div></div></div>");}body_0.__dustBody=!0;return body_0}(dust));

/***/ },
/* 6 */,
/* 7 */
/***/ function(module, exports) {

	module.exports = (function(dust){dust.register("resources\/templates\/admin\/course\/_form",body_0);function body_0(chk,ctx){return chk.w("<div id=\"").f(ctx.get(["modalId"], false),ctx,"h").w("\" class=\"ui modal\"><div class=\"header\">").f(ctx.get(["header"], false),ctx,"h").w("</div><div class=\"content\"><form class=\"ui form\" action=\"").f(ctx.get(["action"], false),ctx,"h").w("\" method=\"").f(ctx.get(["method"], false),ctx,"h").w("\" id=\"").f(ctx.get(["formId"], false),ctx,"h").w("\"><div class=\"field\"><label>课程名称</label><input type=\"text\" name=\"name\" placeholder=\"请输入课程名称\" value=\"").f(ctx.get(["name"], false),ctx,"h").w("\"></div><div class=\"field\"><label>所属门店<select name=\"store_id\" class=\"ui fluid dropdown\"><option value=\"\">请选择门店信息</option>").s(ctx.get(["stores"], false),ctx,{"block":body_1},{}).w("</select></label></div><div class=\"field\"><label>教室</label><select name=\"classroom_id\" class=\"ui fluid dropdown\"><option value=\"\">请选择教室信息</option></select></div><div class=\"field\"><label>教练</label><select name=\"coach_id\" class=\"ui fluid dropdown\"><option value=\"\">请选择教练信息</option>").s(ctx.get(["coaches"], false),ctx,{"block":body_2},{}).w("</select></div><div class=\"field\"><label>描述</label><textarea name=\"description\">").f(ctx.get(["description"], false),ctx,"h").w("</textarea></div><div class=\"field\"><label>注意事项</label><textarea name=\"needing_attention\">").f(ctx.get(["needing_attention"], false),ctx,"h").w("</textarea></div></form></div><div class=\"actions\"><div class=\"ui blue approve button\">").f(ctx.get(["saveText"], false),ctx,"h").w("</div><div class=\"ui deny button\">取 消</div></div></div>");}body_0.__dustBody=!0;function body_1(chk,ctx){return chk.w("<option value=\"").f(ctx.get(["id"], false),ctx,"h").w("\">").f(ctx.get(["name"], false),ctx,"h").w("</option>");}body_1.__dustBody=!0;function body_2(chk,ctx){return chk.w("<option value=\"").f(ctx.get(["id"], false),ctx,"h").w("\">").f(ctx.get(["name"], false),ctx,"h").w("</option>");}body_2.__dustBody=!0;return body_0}(dust));

/***/ },
/* 8 */
/***/ function(module, exports) {

	module.exports = (function(dust){dust.register("resources\/templates\/admin\/course\/_calendar",body_0);function body_0(chk,ctx){return chk.w("<div id=\"").f(ctx.get(["modalId"], false),ctx,"h").w("\" class=\"ui modal\"><div class=\"header\">").f(ctx.get(["header"], false),ctx,"h").w("</div><div class=\"content\"><div class=\"ui grid\"><div class=\"row\"><div class=\"three wide column\">123</div><div class=\"thirteen wide column\">345</div></div></div></div><div class=\"actions\"><div class=\"ui deny button\">").f(ctx.get(["backText"], false),ctx,"h").w("</div><div class=\"ui blue approve button\">").f(ctx.get(["saveText"], false),ctx,"h").w("</div></div></div>");}body_0.__dustBody=!0;return body_0}(dust));

/***/ }
/******/ ]);