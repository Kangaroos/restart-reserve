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

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(1), __webpack_require__(2), __webpack_require__(3)], __WEBPACK_AMD_DEFINE_RESULT__ = function($, dust, $script){
	    $('.special.cards .image').dimmer({
	        on: 'hover'
	    });

	    var formTmpl = __webpack_require__(9);
	    var alertTmpl = __webpack_require__(5);

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
	                },
	                mobile: {
	                    identifier: 'mobile',
	                    rules: [
	                        {
	                            type   : 'empty',
	                            prompt : 'Please enter your mobile'
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

	    $('#createStoreBtn').on('click', function(e) {
	        var formId = 'createStoreForm';
	        $('.ui.modals').remove();
	        dust.render(formTmpl, {
	            formId: formId,
	            header:'新增门店',
	            saveText: '保 存',
	            action: '/admin/stores',
	            method: 'POST'
	        }, function(err, result) {
	            document.body.insertAdjacentHTML('beforeend', result);
	            var $form = $('#' + formId);

	            formValid($form);

	            $('.ui.modal').modal({
	                closable  : false,
	                onDeny    : function(){
	                },
	                onApprove : function() {
	                    $form.trigger('submit');
	                    return false;
	                }
	            }).modal('show');
	        });
	    });

	    $('div[data-id="editStoreBtn"]').on('click', function(e) {
	        var formId = 'editStoreForm';
	        var card = $(this).closest('.ui.card'), storeId = card.data('id');

	        $('.ui.modals').remove();

	        $.ajax({
	            url: ['/admin/stores/',storeId].join(''),
	            type: 'GET',
	            dataType: 'json'
	        }).done(function(ret) {
	            var renderData = $.extend({
	                formId: formId,
	                header:'修改门店',
	                saveText: '更 新',
	                action: ['/admin/stores/', storeId].join(''),
	                method: 'PUT'
	            }, ret);

	            dust.render(formTmpl, renderData, function(err, result) {
	                document.body.insertAdjacentHTML('beforeend', result);

	                var $form = $('#' + formId);

	                formValid($form);

	                $('.ui.modal').modal({
	                    closable  : false,
	                    onDeny    : function(){
	                    },
	                    onApprove : function() {
	                        $form.trigger('submit');
	                        return false;
	                    }
	                }).modal('show');
	            });
	        });
	    });

	    $('div[data-id="updateCoverBtn"]').on('click', function(e) {
	        $(this).closest('.ui.card').find('.cover-upload-input').trigger('click',e);
	    });

	    $('div[data-id="deleteStoreBtn"]').on('click', function(e) {
	        var card = $(this).closest('.ui.card'),storeId = card.data('id');
	        $('.ui.basic.modals').remove();
	        dust.render(alertTmpl, {status: 'warning', desc: '确定要删除门店信息?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
	            document.body.insertAdjacentHTML('beforeend', result);
	            $('.ui.basic.modal')
	                .modal({
	                    closable  : false,
	                    onDeny    : function(){
	                    },
	                    onApprove : function() {
	                        $.ajax({
	                            url: ['/admin/stores/', storeId].join(''),
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

	    $('.cover-upload-input').on('change', function(){
	        var card = $(this).closest('.ui.card'),storeId = card.data('id'), image = card.find('.cover-image');
	        var file = this.files[0];
	        var type = $.trim(file.type);
	        if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
	            || ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )
	        ) {
	            alert('请选择正确的图片')
	        } else {
	            $('.ui.basic.modals').remove();
	            dust.render(alertTmpl, {status: 'warning', desc: '确定要替换封面吗?', denyButtonText: '否', confirmButtonText: '是'}, function(err, result) {
	                document.body.insertAdjacentHTML('beforeend', result);
	                $('.ui.basic.modal')
	                    .modal({
	                        closable  : false,
	                        onDeny    : function(){
	                        },
	                        onApprove : function() {
	                            var data = new FormData();
	                            data.append('cover', file);
	                            $.ajax({
	                                url: ['/admin/stores/cover/', storeId].join(''),
	                                type: 'POST',
	                                data: data,
	                                processData: false,
	                                contentType: false
	                            }).done(function(ret){
	                                $('.ui.basic.modal').modal('hide');
	                                window.location.reload();
	                            });
	                            return false;
	                        }
	                    })
	                    .modal('show');
	            });
	        }
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
/* 7 */,
/* 8 */,
/* 9 */
/***/ function(module, exports) {

	module.exports = (function(dust){dust.register("resources\/templates\/admin\/store\/_form",body_0);function body_0(chk,ctx){return chk.w("<div class=\"ui modal\"><div class=\"header\">").f(ctx.get(["header"], false),ctx,"h").w("</div><div class=\"content\"><form class=\"ui form\" action=\"").f(ctx.get(["action"], false),ctx,"h").w("\" method=\"").f(ctx.get(["method"], false),ctx,"h").w("\" id=\"").f(ctx.get(["formId"], false),ctx,"h").w("\"><div class=\"field\"><label>门店名称</label><input type=\"text\" name=\"name\" placeholder=\"请输入门店名称\" value=\"").f(ctx.get(["name"], false),ctx,"h").w("\"></div><div class=\"two fields\"><div class=\"field\"><label>开业时间</label><input type=\"text\" name=\"startup_at\" placeholder=\"请输入开业时间,格式2014-02-14\" value=\"").f(ctx.get(["startup_at"], false),ctx,"h").w("\"></div><div class=\"field\"><label>电话</label><input type=\"tel\" name=\"mobile\" placeholder=\"请输入联系电话\" value=\"").f(ctx.get(["mobile"], false),ctx,"h").w("\"></div></div><div class=\"two fields\"><div class=\"field\"><label>经度</label><input type=\"text\" name=\"lng\" placeholder=\"请输入经度\" value=\"").f(ctx.get(["lng"], false),ctx,"h").w("\"></div><div class=\"field\"><label>纬度</label><input type=\"text\" name=\"lat\" placeholder=\"请输入纬度\" value=\"").f(ctx.get(["lat"], false),ctx,"h").w("\"></div></div><div class=\"field\"><label>门店地址</label><input type=\"text\" name=\"address\" placeholder=\"请输入门店地址\" value=\"").f(ctx.get(["address"], false),ctx,"h").w("\"></div><div class=\"field\"><label>描述</label><textarea name=\"description\">").f(ctx.get(["description"], false),ctx,"h").w("</textarea></div></form></div><div class=\"actions\"><div class=\"ui blue approve button\">").f(ctx.get(["saveText"], false),ctx,"h").w("</div><div class=\"ui deny button\">取 消</div></div></div>");}body_0.__dustBody=!0;return body_0}(dust));

/***/ }
/******/ ]);