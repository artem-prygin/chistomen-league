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

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./common */ "./resources/js/common.js");
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_common__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _register__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./register */ "./resources/js/register.js");
/* harmony import */ var _register__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_register__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _like__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./like */ "./resources/js/like.js");
/* harmony import */ var _like__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_like__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _profile__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./profile */ "./resources/js/profile.js");
/* harmony import */ var _profile__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_profile__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _sliders__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./sliders */ "./resources/js/sliders.js");
/* harmony import */ var _sliders__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_sliders__WEBPACK_IMPORTED_MODULE_4__);






/***/ }),

/***/ "./resources/js/common.js":
/*!********************************!*\
  !*** ./resources/js/common.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  $(document).ready(function () {
    $.fancybox.defaults.loop = true;
  });
}();

/***/ }),

/***/ "./resources/js/like.js":
/*!******************************!*\
  !*** ./resources/js/like.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  $(document).ready(function () {
    $('.like').submit(function (e) {
      e.preventDefault();
      var form = $(this);
      $.ajax({
        type: 'post',
        data: $(this).serialize(),
        url: '/like',
        success: function success(res) {
          var currentLikes = form.children('span').html();

          if (res == 1) {
            form.children('span').html(--currentLikes);
          } else {
            form.children('span').html(++currentLikes);
          }

          form.children('button').toggleClass('btn-danger').toggleClass('btn-success');
        }
      });
    });
  });
}();

/***/ }),

/***/ "./resources/js/profile.js":
/*!*********************************!*\
  !*** ./resources/js/profile.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  var edit = false;
  $('.profile-settings').click(function () {
    $('.profile-info input, .profile-info textarea').attr('disabled', edit);
    edit = !edit;
    $('.profile-block__showOnEdit, .profile-block__hideOnEdit').toggle();
  });
  $('.profile-info').submit(function (e) {
    e.preventDefault();
    $('.profile-alert').remove();
    $.ajax({
      type: 'put',
      data: $(this).serialize(),
      url: '/profile/1',
      success: function success(res) {
        $('.error').html('');
        $('.profile-block__showOnEdit, .profile-block__hideOnEdit').toggle();
        $('.profile-info input, .profile-info textarea').attr('disabled', true);
        edit = false;
        console.log($('[name="instagram_link"]').val());
        var vk = $('[name="vk_link"]').val();
        var insta = $('[name="instagram_link"]').val();
        var about = $('[name="about"]').val();
        $('.profile-vk a').attr('href', vk).html(vk);
        vk === '' ? $('.profile-vk a').attr('disabled', true).html('Ссылка не указана').addClass('placeholder') : $('.profile-vk a').attr('disabled', false).removeClass('placeholder');
        $('.profile-instagram a').attr('href', insta).html(insta);
        insta === '' ? $('.profile-instagram a').attr('disabled', true).html('Ссылка не указана').addClass('placeholder') : $('.profile-instagram a').attr('disabled', false).removeClass('placeholder');
        about === '' ? $('.profile-about p span').html('Нет информации').addClass('placeholder') : $('.profile-about p span').html(about).removeClass('placeholder');
        $('.profile-container').prepend("<div class=\"alert alert-success alert-dismissible fade show profile-alert\" role=\"alert\">\n                      <span>".concat(res, "</span>\n                      <button class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                         <span aria-hidden=\"true\">&times;</span>\n                      </button>\n                    </div>"));
      },
      error: function error(err) {
        for (var errorMsg in err.responseJSON.errors) {
          $('.error-' + errorMsg).html(err.responseJSON.errors[errorMsg][0]);
        }

        $('.profile-container').prepend("<div class=\"alert alert-danger alert-dismissible fade show profile-alert\" role=\"alert\">\n                      <span>\u0427\u0442\u043E-\u0442\u043E \u043F\u043E\u0448\u043B\u043E \u043D\u0435 \u0442\u0430\u043A, \u043F\u043E\u043F\u0440\u043E\u0431\u0443\u0439\u0442\u0435 \u0435\u0449\u0435 \u0440\u0430\u0437</span>\n                      <button class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n                         <span aria-hidden=\"true\">&times;</span>\n                      </button>\n                    </div>");
      }
    });
  }); // uploading avatars

  (function () {
    'use strict';

    $('.input-file').each(function () {
      var $input = $(this),
          $label = $input.next('.js-labelFile'),
          labelVal = $label.html();
      $input.on('change', function (element) {
        var fileName = '';
        if (element.target.value) fileName = element.target.value.split('\\').pop();
        fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
      });
    });
  })();

  $('.profile-img__input').on('change', function () {
    $('.profile-img__upload').submit();
  }); // posts slider at profile

  $('.post-blocks__slider').owlCarousel({
    items: 1,
    loop: true,
    nav: true,
    navText: ["<i class='fa fa-chevron-left post-blocks__arrow post-blocks__arrow-left'></i>", "<i class='fa fa-chevron-right post-blocks__arrow post-blocks__arrow-right'></i>"]
  }); //create post select2

  $('.post-category').select2({
    placeholder: "Выберите категорию",
    multiply: true,
    language: {
      noResults: function noResults(params) {
        return "Ничего не найдено :(";
      },
      maximumSelected: function maximumSelected(e) {
        return "Можно выбрать только одну категорию";
      }
    },
    maximumSelectionLength: 1,
    minimumInputLength: 0
  }).on('change', function () {
    $(this).val()[0] === undefined ? $('.post-category__new').attr('disabled', false) : $('.post-category__new').attr('disabled', true);
  });
  $('.post-category__new').on('input', function () {
    $(this).val() === '' ? $('.post-category').attr('disabled', false) : $('.post-category').attr('disabled', true);
  });

  if ($('.post-category').length && $('.post-category').val()[0] !== undefined) {
    $('.post-category__new').attr('disabled', true);
  }

  if ($('.post-category__new').length && $('.post-category__new').val() !== '') {
    $('.post-category').attr('disabled', true);
  }
}();

/***/ }),

/***/ "./resources/js/register.js":
/*!**********************************!*\
  !*** ./resources/js/register.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  $(document).ready(function () {
    //регистрация групп
    $('.group-register').select2({
      placeholder: "Выберите клан",
      multiply: true,
      language: {
        noResults: function noResults(params) {
          return "Ничего не найдено :(";
        },
        maximumSelected: function maximumSelected(e) {
          return "Можно выбрать только один клан";
        }
      },
      maximumSelectionLength: 1,
      minimumInputLength: 0
    });
  });
}();

/***/ }),

/***/ "./resources/js/sliders.js":
/*!*********************************!*\
  !*** ./resources/js/sliders.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function () {
  $(document).ready(function () {
    $('.post-images__slider').owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      navText: ["<i class='fa fa-chevron-left post-arrow post-arrow__left'></i>", "<i class='fa fa-chevron-right post-arrow post-arrow__right'></i>"]
    });
    $('.post-block__img').owlCarousel({
      items: 1,
      loop: true,
      mouseDrag: false,
      touchDrag: false,
      pullDrag: false,
      nav: false,
      dots: false
    });
  });
}();

/***/ }),

/***/ "./resources/sass/style.sass":
/*!***********************************!*\
  !*** ./resources/sass/style.sass ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/style.sass ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/wellyes/PhpstormProjects/chistomen-league/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/wellyes/PhpstormProjects/chistomen-league/resources/sass/style.sass */"./resources/sass/style.sass");


/***/ })

/******/ });