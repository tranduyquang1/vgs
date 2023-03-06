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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/frontend/myScript.js":
/*!*******************************************!*\
  !*** ./resources/js/frontend/myScript.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/* List event document ready */
$(document).ready(function () {
  var $scrollHref = $('.scroll-href');
  /* Scroll href */

  $scrollHref.click(function (e) {
    var href = $(e.target).attr("href");
    $('html, body').animate({
      scrollTop: $(href).offset().top - 200
    }, 500);
    return false;
  }); // lazyload

  var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy",
    load_delay: 0,
    threshold: 10
  }); // Count down

  $('.countdown').countDown();
}); // create plugin jquery countdown

(function ($) {
  $.fn.countDown = function () {
    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var $this = $(this);
    var date = $this.data('date');
    var countDownDate = new Date(date).getTime(); // Update the count down every 1 second

    var x = setInterval(function () {
      // Get today's date and time
      var now = new Date().getTime(); // Find the distance between now and the count down date

      var distance = countDownDate - now; // Time calculations for days, hours, minutes and seconds

      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(distance % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
      var minutes = Math.floor(distance % (1000 * 60 * 60) / (1000 * 60));
      var seconds = Math.floor(distance % (1000 * 60) / 1000); // Show time

      $this.find('#days').text(days);
      $this.find('#hours').text(hours);
      $this.find('#minutes').text(minutes);
      $this.find('#seconds').text(seconds); // If the count down is finished, write some text

      if (distance < 0) {
        clearInterval(x); // Reset time

        $this.find('#days').text(0);
        $this.find('#hours').text(0);
        $this.find('#minutes').text(0);
        $this.find('#seconds').text(0);
      }
    }, 1000);
  };
})(jQuery);

/***/ }),

/***/ 1:
/*!*************************************************!*\
  !*** multi ./resources/js/frontend/myScript.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\XAMPP\htdocs\gilimex_xuathang\resources\js\frontend\myScript.js */"./resources/js/frontend/myScript.js");


/***/ })

/******/ });