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
/*! no static exports found */
/***/ (function(module, exports) {

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
  var edit = false;
  $('.profile-settings').click(function () {
    edit === false ? $('.profile-info input, .profile-info textarea').removeClass('disabled').removeAttr('disabled') : $('.profile-info input, .profile-info textarea').addClass('disabled').attr('disabled');
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
    navText: ["<i class='fa fa-chevron-left post-blocks__arrow post-blocks__arrow-left'></i>", "<i class='fa fa-chevron-right post-blocks__arrow post-blocks__arrow-right'></i>"],
    autoHeight: true
  });
});

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