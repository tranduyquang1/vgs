/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/backend/myScript.js":
/*!******************************************!*\
  !*** ./resources/js/backend/myScript.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var $btnSearch = $("button#btn-search");
  var $btnClearSearch = $("button#btn-clear-search");
  var $inputSearchField = $("input[name=search_field]");
  var $inputSearchValue = $("input[name=search_value]");
  var $statusAjax = $("button.status-ajax");
  var $bccContactAjax = $("button.bcc_contact-ajax");
  var $categoryName = $("input[name=name]");
  var $categorySlug = $("input[name=slug]");
  var $selectAttr = $("select.select-ajax");
  var $selectFilter = $("select[name = select_filter]");
  var $price_default = $("input[name=price_default]");
  var $inputOrdering = $("input.input-ordering");
  var $fieldAjax = $('.field-ajax');
  var $alert = $('.alert');
  var $datepicker = $('.datepicker');
  var $lfm = $('.lfm');
  var $selectCategory = $('.select-category');
  var $btnAddView = $('.btn-view-add');
  var $btnBlockCont = $('.btn-block-cont');
  var $searchFilter = $('.search-filter');
  var $btnMail = $('.btn-mail');
  var $btnExportSearch = $('.btn-export-search'); // init library

  $selectCategory.select2();
  $price_default.simpleMoneyFormat();
  $lfm.filemanager('image');
  $datepicker.datepicker({
    format: 'dd-mm-yyyy'
  });
  $alert.delay(2500).hide(1000); // select field

  $("a.select-field").click(function (e) {
    e.preventDefault();
    var field = $(this).data('field');
    var fieldName = $(this).html();
    $("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    $inputSearchField.val(field);
  });
  /* search */

  $btnSearch.click(function () {
    var pathname = window.location.pathname;
    var params = ['filter_status'];
    var searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

    var link = "";
    $.each(params, function (key, param) {
      // filter_status
      if (searchParams.has(param)) {
        link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
      }
    });
    var search_field = $inputSearchField.val();
    var search_value = $inputSearchValue.val();

    if (search_value.replace(/\s/g, "") == "") {
      alert("Nhập vào giá trị cần tìm !");
    } else {
      window.location.href = pathname + "?" + link + 'search_field=' + search_field + '&search_value=' + search_value;
    }
  });
  /* filter status */

  $btnClearSearch.click(function () {
    var pathname = window.location.pathname;
    var searchParams = new URLSearchParams(window.location.search);
    params = ['filter_status'];
    var link = "";
    $.each(params, function (key, param) {
      if (searchParams.has(param)) {
        link += param + "=" + searchParams.get(param) + "&";
      }
    });
    window.location.href = pathname + "?" + link.slice(0, -1);
  });
  /* confirm delete */

  $('.btn-delete').on('click', function () {
    if (!confirm('Bạn có chắc muốn xóa phần tử?')) return false;
  });
  /* change status */

  $statusAjax.on('click', function () {
    var link = $(this).data('link');
    var $selector = $(this);
    $.ajax({
      url: link,
      type: "GET",
      dataType: "json",
      success: function success(result) {
        if (result.status) {
          if (result.response === 'active') $selector.removeClass('btn-info').addClass('btn-success').text('Kích hoạt').data('link', result.link);else $selector.removeClass('btn-success').addClass('btn-info').text('Chưa kích hoạt').data('link', result.link);
          $selector.notify("Cập nhật thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
        } else {
          console.log(result.error);
        }
      }
    });
  });
  /* change Bcc contact */

  $bccContactAjax.on('click', function () {
    var link = $(this).data('link');
    var $selector = $(this);
    $.ajax({
      url: link,
      type: "GET",
      dataType: "json",
      success: function success(result) {
        if (result.status) {
          if (result.response === 'active') $selector.removeClass('btn-warning').addClass('btn-primary').text('Bật').data('link', result.link);else $selector.removeClass('btn-primary').addClass('btn-warning').text('Tắt').data('link', result.link);
          $selector.notify("Cập nhật thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
        } else {
          console.log(result.error);
        }
      }
    });
  });
  /* create slug of category */

  $categoryName.on('change', function () {
    var categoryName = $(this).val();
    if ($categorySlug.val() === '') $categorySlug.val(to_slug(categoryName));
  });
  /* Change attr select box */

  $selectAttr.on('change', function () {
    var url = $(this).data('url');
    var field = $(this).data('field');
    var value = $(this).val();
    var $selector = $(this);
    $.ajax({
      url: url,
      type: "GET",
      data: {
        'field': field,
        'value': value
      },
      dataType: "json",
      success: function success(result) {
        if (result.status) {
          $selector.notify("Cập nhật thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
        } else {
          console.log(result.error);
        }
      }
    });
  });
  $fieldAjax.on('change', function (e) {
    var value = $(this).val();
    var field = $(this).data('field');
    var link = $(this).data('link');
    var $selector = $(this);
    $.ajax({
      url: link,
      type: "GET",
      data: {
        'field': field,
        'value': value
      },
      dataType: "json",
      success: function success(result) {
        if (result.status) {
          $selector.notify("Cập nhật thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
        } else {
          console.log(result.error);
        }
      }
    });
  });
  $btnMail.on('click', function () {
    var link = $(this).data('link');
    var $selector = $(this);
    $.ajax({
      url: link,
      type: "GET",
      dataType: "json",
      success: function success(result) {
        if (result.status) {
          $selector.notify("Gửi mail thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
        } else {
          $selector.notify("Có lỗi xảy ra!", {
            className: 'error',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
          console.log(result.error);
        }
      }
    });
  });
  $selectFilter.on('change', function () {
    var pathname = window.location.pathname;
    var searchParams = new URLSearchParams(window.location.search);
    params = ['page', 'filter_status', 'search_field', 'search_value'];
    var link = "";
    $.each(params, function (key, value) {
      if (searchParams.has(value)) {
        link += value + "=" + searchParams.get(value) + "&";
      }
    });
    var select_field = $(this).data('field');
    var select_value = $(this).val();
    if (link === '') window.location.href = pathname + '?select_field=' + select_field + '&select_value=' + select_value;else window.location.href = pathname + "?" + link.slice(0, -1) + '&select_field=' + select_field + '&select_value=' + select_value;
  });
  /* checkbox ordering */

  $inputOrdering.on('change', function () {
    var id = $(this).data('id');
    var $selector = $('input[name="cid[' + id + ']"]');
    $selector.attr('checked', true);
    $selector.parent().addClass('checked');
    $selector.parent().parent().addClass('selected');
  }); // submit form

  $('.btn-submit').click(function (e) {
    var confirmed = $(e.target).data('confirmed');

    if (confirmed != 1) {
      if (!confirm('Bạn có chắc xác nhận không ?')) {
        e.preventDefault();
        return false;
      }
    }

    var $selector = $(e.target);
    var id = $(e.target).data('id');
    var status = $('select[name="status"][data-id="' + id + '"]').val();

    if (status == 0) {
      $selector.notify("Vui lòng chọn trạng thái", {
        className: 'error',
        autoHideDelay: 3000,
        elementPosition: 'bottom left'
      });
      e.preventDefault();
      return false;
    }
  });
  $(document).on('submit', '.update-form', function (e) {
    e.preventDefault();
    var id = $(e.target).data('id');
    $.ajax({
      url: $(e.target).attr('action'),
      dataType: 'json',
      data: $(e.target).serialize(),
      success: function success(response) {
        if (response.status === true) {
          $.notify("Cập nhật thành công!", {
            className: 'success',
            autoHideDelay: 3000,
            elementPosition: 'top left'
          });
          $(e.target).parent().addClass('tr-highlight');
          $('.history-log[data-id="' + response.id + '"] .display-info').html('<b>' + response.user + '</b> đã cập nhật vào lúc <b>' + response.time + '</b>');
          $('.btn-block-cont[data-id="' + id + '"]').data('confirm', true);
        } else $.notify("Có lỗi xảy ra!", {
          className: 'error',
          autoHideDelay: 3000,
          elementPosition: 'top left'
        });
      }
    });
  }); // btn add view

  $btnAddView.click(function (e) {
    var url = $(e.target).data('url');
    $.ajax({
      url: url,
      dataType: 'html',
      success: function success(response) {
        $('.show-company-form').html('').append(response);
        $('#company-form-modal').modal('show');
      }
    });
  });
  $('.modal').on('show.bs.modal', function (e) {
    $('.datepicker-modal').datepicker({
      format: 'dd-mm-yyyy'
    });
  });
  $btnBlockCont.click(function (e) {
    var $selector = $(e.target);
    var isConfirm = $(e.target).data('confirm');

    if (isConfirm == false) {
      $selector.notify("Bạn chưa xác nhận nên không thể khóa!", {
        className: 'info',
        autoHideDelay: 3000,
        elementPosition: 'top left'
      });
      return false;
    }

    if (!confirm('Bạn có chắc muốn khóa không ?')) return false;
    var id = $(e.target).data('id');
    $(e.target).removeClass('btn-success btn-block-cont').addClass('btn-danger disabled').text('Đã khóa');
    $('.cont_no_block[data-id="' + id + '"]').val(1);
    $('.btn-submit[data-id="' + id + '"]').data('confirmed', 1).trigger('click'); // disbled input when block record

    $('select[name="status"][data-id="' + id + '"]').prop('disabled', true);
    $('input[name="note"][data-itemId="' + id + '"]').attr('disabled', true);
    $('button.btn-submit[data-id="' + id + '"]').attr('disabled', true);
    $('select[name="times_check"][data-id="' + id + '"]').attr('disabled', true);
    $('div.box-hints[data-id="' + id + '"]').addClass('d-none');
  }); // suggestions event input

  $(document).on('click', '.suggestions-input', function (e) {
    e.preventDefault();
    var $selector = $(e.target);
    var id = $selector.data('id');
    var value = $selector.data('value');
    var $target = $('input[name="note"][data-id="' + id + '"]');
    $target.val($target.val() + " " + value);
  }); // search filter files 

  $searchFilter.on('change', function (e) {
    var sheetId = $(e.target).data('sheet');
    var $form = $('.search-filter-form[data-sheet="' + sheetId + '"]');
    $.ajax({
      url: $form.attr('action'),
      type: 'GET',
      data: $form.serialize(),
      dataType: 'json',
      success: function success(response) {
        if (response.status == true) {
          var ids = response.message;
          $('.row-item').addClass('d-none');
          ids.forEach(function (item, index) {
            $('.row-item[data-id="' + item.id + '"]').removeClass('d-none');
          });
        } else {
          console.log(response.message);
        }
      }
    });
  });
  $btnExportSearch.click(function (e) {
    var link = $(e.target).data('link');
    $('.form-search').attr('action', link).submit();
  });
});

function to_slug(str) {
  str = str.toLowerCase();
  str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
  str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
  str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
  str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
  str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
  str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
  str = str.replace(/(đ)/g, 'd');
  str = str.replace(/([^0-9a-z-\s])/g, '');
  str = str.replace(/(\s+)/g, '-');
  str = str.replace(/^-+/g, '');
  str = str.replace(/-+$/g, '');
  return str;
}

/***/ }),

/***/ "./resources/sass/backend/myStyle.scss":
/*!*********************************************!*\
  !*** ./resources/sass/backend/myStyle.scss ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/frontend/myStyle.scss":
/*!**********************************************!*\
  !*** ./resources/sass/frontend/myStyle.scss ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*****************************************************************************************************************************!*\
  !*** multi ./resources/js/backend/myScript.js ./resources/sass/backend/myStyle.scss ./resources/sass/frontend/myStyle.scss ***!
  \*****************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\XAMPP\htdocs\gilimex_xuathang\resources\js\backend\myScript.js */"./resources/js/backend/myScript.js");
__webpack_require__(/*! D:\XAMPP\htdocs\gilimex_xuathang\resources\sass\backend\myStyle.scss */"./resources/sass/backend/myStyle.scss");
module.exports = __webpack_require__(/*! D:\XAMPP\htdocs\gilimex_xuathang\resources\sass\frontend\myStyle.scss */"./resources/sass/frontend/myStyle.scss");


/***/ })

/******/ });