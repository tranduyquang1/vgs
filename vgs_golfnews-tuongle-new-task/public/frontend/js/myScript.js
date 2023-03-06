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

$(document).ready(function () {
  $('.golf-owl-carousel').owlCarousel({
    margin: 10,
    nav: true,
    navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 3
      },
      1000: {
        items: 3
      }
    }
  });
  $(document).on('click', '.golf-banner', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    var href = $(this).attr('href');
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function success(result) {
        window.open(href);
      }
    });
  }); // let categoryTop1 = $('#category-top-1');
  // let bannerHomeSidebar1 = $('#banner-home-sidebar1');
  // let categoryTop2 = $('#category-top-2');
  // let bannerHomeSidebar2 = $('#banner-home-sidebar2');
  // let categoryPageArea1 = $('#category-page-area-1');
  // let bannerCategorySidebar1 = $('#banner-category-sidebar1');
  // let categoryPageArea2 = $('#category-page-area-2');
  // let bannerCategorySidebar2 = $('#banner-category-sidebar2');
  // let categoryPageArea3 = $('#category-page-area-3');
  // let bannerCategorySidebar3 = $('#banner-category-sidebar3');
  // let categoryPageSectionVideo = $('#category-section-video');
  //
  // if (categoryPageArea1.length) {
  //     bannerCategorySidebar1.offset({top: categoryPageArea1.offset().top});
  //     bannerCategorySidebar1.css('height', categoryPageArea1.css('height'));
  // }
  //
  // if (categoryPageArea2.length) {
  //     bannerCategorySidebar2.offset({top: categoryPageArea2.offset().top});
  //     bannerCategorySidebar2.css('height', categoryPageArea2.css('height'));
  // } else {
  //
  // }
  //
  // if (categoryPageArea3.length) {
  //     bannerCategorySidebar3.offset({top: categoryPageArea3.offset().top});
  //     bannerCategorySidebar3.css('height', categoryPageArea3.css('height'));
  // } else {
  //     if (bannerCategorySidebar3.length) {
  //         let marginTop = parseInt(bannerCategorySidebar2.css('height')) + 100 - (bannerCategorySidebar3.offset().top - bannerCategorySidebar2.offset().top);
  //         bannerCategorySidebar3.css('margin-top', marginTop + 'px');
  //     }
  // }
  //
  // $(window).resize(function () {
  //     if (categoryPageArea1.length) {
  //         bannerCategorySidebar1.offset({top: categoryPageArea1.offset().top});
  //         bannerCategorySidebar1.css('height', categoryPageArea1.css('height'));
  //     }
  //
  //     if (categoryPageArea2.length) {
  //         bannerCategorySidebar2.offset({top: categoryPageArea2.offset().top});
  //         bannerCategorySidebar2.css('height', categoryPageArea2.css('height'));
  //     } else {
  //
  //     }
  //
  //     if (categoryPageArea3.length) {
  //         bannerCategorySidebar3.offset({top: categoryPageArea3.offset().top});
  //         bannerCategorySidebar3.css('height', categoryPageArea3.css('height'));
  //     } else {
  //         if (bannerCategorySidebar3.length) {
  //             let marginTop = parseInt(bannerCategorySidebar2.css('height')) + 100 - (bannerCategorySidebar3.offset().top - bannerCategorySidebar2.offset().top);
  //             bannerCategorySidebar3.css('margin-top', marginTop + 'px');
  //         }
  //     }
  // });
  // if (bannerHomeSidebar1.length) {
  //     bannerHomeSidebar1.offset({top: categoryTop1.offset().top});
  //     bannerHomeSidebar1.css('height', categoryTop1.css('height'));
  //     bannerHomeSidebar2.offset({top: categoryTop2.offset().top});
  //     bannerHomeSidebar2.css('height', categoryTop2.css('height'));
  //
  //     $(window).resize(function () {
  //         bannerHomeSidebar1.offset({top: categoryTop1.offset().top});
  //         bannerHomeSidebar1.css('height', categoryTop1.css('height'));
  //         bannerHomeSidebar2.offset({top: categoryTop2.offset().top});
  //         bannerHomeSidebar2.css('height', categoryTop2.css('height'));
  //     });
  // }

  $('#btn-load-more-level2').on('click', function () {
    var ele = $(this);
    var url = ele.data('url');
    var page = ele.data('page');
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        page: page
      },
      dataType: 'html',
      beforeSend: function beforeSend() {
        ele.html('<div class="spinner-grow spinner-grow-sm mr-2" role="status"><span class="visually-hidden">Loading...</span></div>');
      },
      success: function success(result) {
        ele.html('Xem thêm');
        $('.golf-post-list').append(result);
        ele.data('page', ++page);
      }
    });
  });
  $('.ajax-content').each(function (index, element) {
    $.ajax({
      type: 'GET',
      url: $(element).data('url'),
      dataType: 'html',
      success: function success(response) {
        $(element).html(response);
      }
    });
  });
  var golfPostDetail = $('#golf-post-detail');
  var adsInpageFullscreen = $('#ads-inpage-fullscreen');

  if (golfPostDetail.length && adsInpageFullscreen.length) {
    var tags = $('#golf-post-detail > *');
    var idx = Math.round(tags.length / 2);
    var html = adsInpageFullscreen.html();
    $(html).insertBefore(tags[idx]);
  }
});

/***/ }),

/***/ 1:
/*!*************************************************!*\
  !*** multi ./resources/js/frontend/myScript.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\working\vgs_golfnews\resources\js\frontend\myScript.js */"./resources/js/frontend/myScript.js");


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2pzL2Zyb250ZW5kL215U2NyaXB0LmpzIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsInJlYWR5Iiwib3dsQ2Fyb3VzZWwiLCJtYXJnaW4iLCJuYXYiLCJuYXZUZXh0IiwicmVzcG9uc2l2ZSIsIml0ZW1zIiwib24iLCJlIiwicHJldmVudERlZmF1bHQiLCJ1cmwiLCJkYXRhIiwiaHJlZiIsImF0dHIiLCJhamF4IiwidHlwZSIsImRhdGFUeXBlIiwic3VjY2VzcyIsInJlc3VsdCIsIndpbmRvdyIsIm9wZW4iLCJlbGUiLCJwYWdlIiwiYmVmb3JlU2VuZCIsImh0bWwiLCJhcHBlbmQiLCJlYWNoIiwiaW5kZXgiLCJlbGVtZW50IiwicmVzcG9uc2UiLCJnb2xmUG9zdERldGFpbCIsImFkc0lucGFnZUZ1bGxzY3JlZW4iLCJsZW5ndGgiLCJ0YWdzIiwiaWR4IiwiTWF0aCIsInJvdW5kIiwiaW5zZXJ0QmVmb3JlIl0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7OztRQUdBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwwQ0FBMEMsZ0NBQWdDO1FBQzFFO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0Esd0RBQXdELGtCQUFrQjtRQUMxRTtRQUNBLGlEQUFpRCxjQUFjO1FBQy9EOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQSx5Q0FBeUMsaUNBQWlDO1FBQzFFLGdIQUFnSCxtQkFBbUIsRUFBRTtRQUNySTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDJCQUEyQiwwQkFBMEIsRUFBRTtRQUN2RCxpQ0FBaUMs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QUFTSCxHQWJEO0FBZUF4QixHQUFDLENBQUMsZUFBRCxDQUFELENBQW1CNEIsSUFBbkIsQ0FBd0IsVUFBVUMsS0FBVixFQUFpQkMsT0FBakIsRUFBMEI7QUFDOUM5QixLQUFDLENBQUNnQixJQUFGLENBQU87QUFDSEMsVUFBSSxFQUFFLEtBREg7QUFFSEwsU0FBRyxFQUFFWixDQUFDLENBQUM4QixPQUFELENBQUQsQ0FBV2pCLElBQVgsQ0FBZ0IsS0FBaEIsQ0FGRjtBQUdISyxjQUFRLEVBQUUsTUFIUDtBQUlIQyxhQUFPLEVBQUUsaUJBQVVZLFFBQVYsRUFBb0I7QUFDekIvQixTQUFDLENBQUM4QixPQUFELENBQUQsQ0FBV0osSUFBWCxDQUFnQkssUUFBaEI7QUFDSDtBQU5FLEtBQVA7QUFRSCxHQVREO0FBV0EsTUFBSUMsY0FBYyxHQUFHaEMsQ0FBQyxDQUFDLG1CQUFELENBQXRCO0FBQ0EsTUFBSWlDLG1CQUFtQixHQUFHakMsQ0FBQyxDQUFDLHdCQUFELENBQTNCOztBQUNBLE1BQUlnQyxjQUFjLENBQUNFLE1BQWYsSUFBeUJELG1CQUFtQixDQUFDQyxNQUFqRCxFQUF5RDtBQUNyRCxRQUFJQyxJQUFJLEdBQUduQyxDQUFDLENBQUMsdUJBQUQsQ0FBWjtBQUNBLFFBQUlvQyxHQUFHLEdBQUdDLElBQUksQ0FBQ0MsS0FBTCxDQUFXSCxJQUFJLENBQUNELE1BQUwsR0FBYyxDQUF6QixDQUFWO0FBQ0EsUUFBSVIsSUFBSSxHQUFHTyxtQkFBbUIsQ0FBQ1AsSUFBcEIsRUFBWDtBQUNBMUIsS0FBQyxDQUFDMEIsSUFBRCxDQUFELENBQVFhLFlBQVIsQ0FBcUJKLElBQUksQ0FBQ0MsR0FBRCxDQUF6QjtBQUNIO0FBQ0osQ0FySUQsRSIsImZpbGUiOiIvZnJvbnRlbmQvanMvbXlTY3JpcHQuanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIi9cIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IDEpO1xuIiwiJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkge1xyXG4gICAgJCgnLmdvbGYtb3dsLWNhcm91c2VsJykub3dsQ2Fyb3VzZWwoe1xyXG4gICAgICAgIG1hcmdpbjogMTAsXHJcbiAgICAgICAgbmF2OiB0cnVlLFxyXG4gICAgICAgIG5hdlRleHQ6IFtcIjxkaXYgY2xhc3M9J25hdi1idG4gcHJldi1zbGlkZSc+PC9kaXY+XCIsIFwiPGRpdiBjbGFzcz0nbmF2LWJ0biBuZXh0LXNsaWRlJz48L2Rpdj5cIl0sXHJcbiAgICAgICAgcmVzcG9uc2l2ZToge1xyXG4gICAgICAgICAgICAwOiB7aXRlbXM6IDF9LFxyXG4gICAgICAgICAgICA2MDA6IHtpdGVtczogM30sXHJcbiAgICAgICAgICAgIDEwMDA6IHtpdGVtczogM31cclxuICAgICAgICB9XHJcbiAgICB9KTtcclxuXHJcbiAgICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnLmdvbGYtYmFubmVyJywgZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgbGV0IHVybCA9ICQodGhpcykuZGF0YSgndXJsJyk7XHJcbiAgICAgICAgbGV0IGhyZWYgPSAkKHRoaXMpLmF0dHIoJ2hyZWYnKTtcclxuICAgICAgICAkLmFqYXgoe1xyXG4gICAgICAgICAgICB1cmw6IHVybCxcclxuICAgICAgICAgICAgdHlwZTogJ0dFVCcsXHJcbiAgICAgICAgICAgIGRhdGFUeXBlOiAnanNvbicsXHJcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChyZXN1bHQpIHtcclxuICAgICAgICAgICAgICAgIHdpbmRvdy5vcGVuKGhyZWYpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxuXHJcbiAgICAvLyBsZXQgY2F0ZWdvcnlUb3AxID0gJCgnI2NhdGVnb3J5LXRvcC0xJyk7XHJcbiAgICAvLyBsZXQgYmFubmVySG9tZVNpZGViYXIxID0gJCgnI2Jhbm5lci1ob21lLXNpZGViYXIxJyk7XHJcbiAgICAvLyBsZXQgY2F0ZWdvcnlUb3AyID0gJCgnI2NhdGVnb3J5LXRvcC0yJyk7XHJcbiAgICAvLyBsZXQgYmFubmVySG9tZVNpZGViYXIyID0gJCgnI2Jhbm5lci1ob21lLXNpZGViYXIyJyk7XHJcblxyXG4gICAgLy8gbGV0IGNhdGVnb3J5UGFnZUFyZWExID0gJCgnI2NhdGVnb3J5LXBhZ2UtYXJlYS0xJyk7XHJcbiAgICAvLyBsZXQgYmFubmVyQ2F0ZWdvcnlTaWRlYmFyMSA9ICQoJyNiYW5uZXItY2F0ZWdvcnktc2lkZWJhcjEnKTtcclxuICAgIC8vIGxldCBjYXRlZ29yeVBhZ2VBcmVhMiA9ICQoJyNjYXRlZ29yeS1wYWdlLWFyZWEtMicpO1xyXG4gICAgLy8gbGV0IGJhbm5lckNhdGVnb3J5U2lkZWJhcjIgPSAkKCcjYmFubmVyLWNhdGVnb3J5LXNpZGViYXIyJyk7XHJcbiAgICAvLyBsZXQgY2F0ZWdvcnlQYWdlQXJlYTMgPSAkKCcjY2F0ZWdvcnktcGFnZS1hcmVhLTMnKTtcclxuICAgIC8vIGxldCBiYW5uZXJDYXRlZ29yeVNpZGViYXIzID0gJCgnI2Jhbm5lci1jYXRlZ29yeS1zaWRlYmFyMycpO1xyXG4gICAgLy8gbGV0IGNhdGVnb3J5UGFnZVNlY3Rpb25WaWRlbyA9ICQoJyNjYXRlZ29yeS1zZWN0aW9uLXZpZGVvJyk7XHJcbiAgICAvL1xyXG4gICAgLy8gaWYgKGNhdGVnb3J5UGFnZUFyZWExLmxlbmd0aCkge1xyXG4gICAgLy8gICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjEub2Zmc2V0KHt0b3A6IGNhdGVnb3J5UGFnZUFyZWExLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjEuY3NzKCdoZWlnaHQnLCBjYXRlZ29yeVBhZ2VBcmVhMS5jc3MoJ2hlaWdodCcpKTtcclxuICAgIC8vIH1cclxuICAgIC8vXHJcbiAgICAvLyBpZiAoY2F0ZWdvcnlQYWdlQXJlYTIubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgYmFubmVyQ2F0ZWdvcnlTaWRlYmFyMi5vZmZzZXQoe3RvcDogY2F0ZWdvcnlQYWdlQXJlYTIub2Zmc2V0KCkudG9wfSk7XHJcbiAgICAvLyAgICAgYmFubmVyQ2F0ZWdvcnlTaWRlYmFyMi5jc3MoJ2hlaWdodCcsIGNhdGVnb3J5UGFnZUFyZWEyLmNzcygnaGVpZ2h0JykpO1xyXG4gICAgLy8gfSBlbHNlIHtcclxuICAgIC8vXHJcbiAgICAvLyB9XHJcbiAgICAvL1xyXG4gICAgLy8gaWYgKGNhdGVnb3J5UGFnZUFyZWEzLmxlbmd0aCkge1xyXG4gICAgLy8gICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjMub2Zmc2V0KHt0b3A6IGNhdGVnb3J5UGFnZUFyZWEzLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjMuY3NzKCdoZWlnaHQnLCBjYXRlZ29yeVBhZ2VBcmVhMy5jc3MoJ2hlaWdodCcpKTtcclxuICAgIC8vIH0gZWxzZSB7XHJcbiAgICAvLyAgICAgaWYgKGJhbm5lckNhdGVnb3J5U2lkZWJhcjMubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgICAgIGxldCBtYXJnaW5Ub3AgPSBwYXJzZUludChiYW5uZXJDYXRlZ29yeVNpZGViYXIyLmNzcygnaGVpZ2h0JykpICsgMTAwIC0gKGJhbm5lckNhdGVnb3J5U2lkZWJhcjMub2Zmc2V0KCkudG9wIC0gYmFubmVyQ2F0ZWdvcnlTaWRlYmFyMi5vZmZzZXQoKS50b3ApO1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJDYXRlZ29yeVNpZGViYXIzLmNzcygnbWFyZ2luLXRvcCcsIG1hcmdpblRvcCArICdweCcpO1xyXG4gICAgLy8gICAgIH1cclxuICAgIC8vIH1cclxuICAgIC8vXHJcbiAgICAvLyAkKHdpbmRvdykucmVzaXplKGZ1bmN0aW9uICgpIHtcclxuICAgIC8vICAgICBpZiAoY2F0ZWdvcnlQYWdlQXJlYTEubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjEub2Zmc2V0KHt0b3A6IGNhdGVnb3J5UGFnZUFyZWExLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJDYXRlZ29yeVNpZGViYXIxLmNzcygnaGVpZ2h0JywgY2F0ZWdvcnlQYWdlQXJlYTEuY3NzKCdoZWlnaHQnKSk7XHJcbiAgICAvLyAgICAgfVxyXG4gICAgLy9cclxuICAgIC8vICAgICBpZiAoY2F0ZWdvcnlQYWdlQXJlYTIubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjIub2Zmc2V0KHt0b3A6IGNhdGVnb3J5UGFnZUFyZWEyLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJDYXRlZ29yeVNpZGViYXIyLmNzcygnaGVpZ2h0JywgY2F0ZWdvcnlQYWdlQXJlYTIuY3NzKCdoZWlnaHQnKSk7XHJcbiAgICAvLyAgICAgfSBlbHNlIHtcclxuICAgIC8vXHJcbiAgICAvLyAgICAgfVxyXG4gICAgLy9cclxuICAgIC8vICAgICBpZiAoY2F0ZWdvcnlQYWdlQXJlYTMubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjMub2Zmc2V0KHt0b3A6IGNhdGVnb3J5UGFnZUFyZWEzLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJDYXRlZ29yeVNpZGViYXIzLmNzcygnaGVpZ2h0JywgY2F0ZWdvcnlQYWdlQXJlYTMuY3NzKCdoZWlnaHQnKSk7XHJcbiAgICAvLyAgICAgfSBlbHNlIHtcclxuICAgIC8vICAgICAgICAgaWYgKGJhbm5lckNhdGVnb3J5U2lkZWJhcjMubGVuZ3RoKSB7XHJcbiAgICAvLyAgICAgICAgICAgICBsZXQgbWFyZ2luVG9wID0gcGFyc2VJbnQoYmFubmVyQ2F0ZWdvcnlTaWRlYmFyMi5jc3MoJ2hlaWdodCcpKSArIDEwMCAtIChiYW5uZXJDYXRlZ29yeVNpZGViYXIzLm9mZnNldCgpLnRvcCAtIGJhbm5lckNhdGVnb3J5U2lkZWJhcjIub2Zmc2V0KCkudG9wKTtcclxuICAgIC8vICAgICAgICAgICAgIGJhbm5lckNhdGVnb3J5U2lkZWJhcjMuY3NzKCdtYXJnaW4tdG9wJywgbWFyZ2luVG9wICsgJ3B4Jyk7XHJcbiAgICAvLyAgICAgICAgIH1cclxuICAgIC8vICAgICB9XHJcbiAgICAvLyB9KTtcclxuXHJcbiAgICAvLyBpZiAoYmFubmVySG9tZVNpZGViYXIxLmxlbmd0aCkge1xyXG4gICAgLy8gICAgIGJhbm5lckhvbWVTaWRlYmFyMS5vZmZzZXQoe3RvcDogY2F0ZWdvcnlUb3AxLm9mZnNldCgpLnRvcH0pO1xyXG4gICAgLy8gICAgIGJhbm5lckhvbWVTaWRlYmFyMS5jc3MoJ2hlaWdodCcsIGNhdGVnb3J5VG9wMS5jc3MoJ2hlaWdodCcpKTtcclxuICAgIC8vICAgICBiYW5uZXJIb21lU2lkZWJhcjIub2Zmc2V0KHt0b3A6IGNhdGVnb3J5VG9wMi5vZmZzZXQoKS50b3B9KTtcclxuICAgIC8vICAgICBiYW5uZXJIb21lU2lkZWJhcjIuY3NzKCdoZWlnaHQnLCBjYXRlZ29yeVRvcDIuY3NzKCdoZWlnaHQnKSk7XHJcbiAgICAvL1xyXG4gICAgLy8gICAgICQod2luZG93KS5yZXNpemUoZnVuY3Rpb24gKCkge1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJIb21lU2lkZWJhcjEub2Zmc2V0KHt0b3A6IGNhdGVnb3J5VG9wMS5vZmZzZXQoKS50b3B9KTtcclxuICAgIC8vICAgICAgICAgYmFubmVySG9tZVNpZGViYXIxLmNzcygnaGVpZ2h0JywgY2F0ZWdvcnlUb3AxLmNzcygnaGVpZ2h0JykpO1xyXG4gICAgLy8gICAgICAgICBiYW5uZXJIb21lU2lkZWJhcjIub2Zmc2V0KHt0b3A6IGNhdGVnb3J5VG9wMi5vZmZzZXQoKS50b3B9KTtcclxuICAgIC8vICAgICAgICAgYmFubmVySG9tZVNpZGViYXIyLmNzcygnaGVpZ2h0JywgY2F0ZWdvcnlUb3AyLmNzcygnaGVpZ2h0JykpO1xyXG4gICAgLy8gICAgIH0pO1xyXG4gICAgLy8gfVxyXG5cclxuICAgICQoJyNidG4tbG9hZC1tb3JlLWxldmVsMicpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBsZXQgZWxlID0gJCh0aGlzKTtcclxuICAgICAgICBsZXQgdXJsID0gZWxlLmRhdGEoJ3VybCcpO1xyXG4gICAgICAgIGxldCBwYWdlID0gZWxlLmRhdGEoJ3BhZ2UnKTtcclxuICAgICAgICAkLmFqYXgoe1xyXG4gICAgICAgICAgICB1cmw6IHVybCwgdHlwZTogJ0dFVCcsIGRhdGE6IHtwYWdlfSwgZGF0YVR5cGU6ICdodG1sJywgYmVmb3JlU2VuZDogZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgZWxlLmh0bWwoJzxkaXYgY2xhc3M9XCJzcGlubmVyLWdyb3cgc3Bpbm5lci1ncm93LXNtIG1yLTJcIiByb2xlPVwic3RhdHVzXCI+PHNwYW4gY2xhc3M9XCJ2aXN1YWxseS1oaWRkZW5cIj5Mb2FkaW5nLi4uPC9zcGFuPjwvZGl2PicpO1xyXG4gICAgICAgICAgICB9LCBzdWNjZXNzOiBmdW5jdGlvbiAocmVzdWx0KSB7XHJcbiAgICAgICAgICAgICAgICBlbGUuaHRtbCgnWGVtIHRow6ptJyk7XHJcbiAgICAgICAgICAgICAgICAkKCcuZ29sZi1wb3N0LWxpc3QnKS5hcHBlbmQocmVzdWx0KTtcclxuICAgICAgICAgICAgICAgIGVsZS5kYXRhKCdwYWdlJywgKytwYWdlKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcblxyXG4gICAgJCgnLmFqYXgtY29udGVudCcpLmVhY2goZnVuY3Rpb24gKGluZGV4LCBlbGVtZW50KSB7XHJcbiAgICAgICAgJC5hamF4KHtcclxuICAgICAgICAgICAgdHlwZTogJ0dFVCcsXHJcbiAgICAgICAgICAgIHVybDogJChlbGVtZW50KS5kYXRhKCd1cmwnKSxcclxuICAgICAgICAgICAgZGF0YVR5cGU6ICdodG1sJyxcclxuICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgICAgICAgICAkKGVsZW1lbnQpLmh0bWwocmVzcG9uc2UpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgfSk7XHJcbiAgICB9KTtcclxuXHJcbiAgICBsZXQgZ29sZlBvc3REZXRhaWwgPSAkKCcjZ29sZi1wb3N0LWRldGFpbCcpO1xyXG4gICAgbGV0IGFkc0lucGFnZUZ1bGxzY3JlZW4gPSAkKCcjYWRzLWlucGFnZS1mdWxsc2NyZWVuJyk7XHJcbiAgICBpZiAoZ29sZlBvc3REZXRhaWwubGVuZ3RoICYmIGFkc0lucGFnZUZ1bGxzY3JlZW4ubGVuZ3RoKSB7XHJcbiAgICAgICAgbGV0IHRhZ3MgPSAkKCcjZ29sZi1wb3N0LWRldGFpbCA+IConKTtcclxuICAgICAgICBsZXQgaWR4ID0gTWF0aC5yb3VuZCh0YWdzLmxlbmd0aCAvIDIpO1xyXG4gICAgICAgIGxldCBodG1sID0gYWRzSW5wYWdlRnVsbHNjcmVlbi5odG1sKCk7XHJcbiAgICAgICAgJChodG1sKS5pbnNlcnRCZWZvcmUodGFnc1tpZHhdKTtcclxuICAgIH1cclxufSk7Il0sInNvdXJjZVJvb3QiOiIifQ==