 // comments slider start
  jQuery(document).ready(function($) {
        $('.comments-slider').slick({
            arrows: false,
            infinite: true,
            variableWidth: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            dots: false,
            centerMode: true,
            speed: 1300,
            autoplaySpeed: 3000,
            responsive: [
           {
             breakpoint: 1300,
             settings: {
               slidesToShow: 2,
               slidesToScroll: 1
             }
           },
           {
             breakpoint: 1200,
             settings: {
               slidesToShow: 1,
               slidesToScroll: 1
             }
           },
           {
             breakpoint: 992,
             settings: {
               slidesToShow: 1,
               slidesToScroll: 1
             }
           },
           {
             breakpoint: 576,
             settings: {
               slidesToShow: 1,
                centerMode: true,
               slidesToScroll: 1
             }
           }
         ]


          });
  });
  // comments slider end

// убрать hover на 768 и ниже
jQuery(document).ready(function($) {
  if ($(window).width() <= 768) {
    $('.popular-block').toggleClass('popular-block popular-block__nohover');
  }
});

// fancybox gallery start
$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
        transitionEffect: "slide",
        animationEffect: "zoom",
        animationDuration: 200,
        buttons : [
        // 'zoom',
        'close'
        ]
});
});
// fancybox gallery end

jQuery(document).ready(function($) {
  new WOW().init();
});

// гамбургер меню
jQuery(document).ready(function($) {
  $(function(){
  var width   = 200,
      height  = 44 * 4 + 20,
      speed   = 300,
      button  = $('#menu-button'),
      overlay = $('#overlay'),
      menu    = $('#hamburger-menu');

  button.on('click',function(e){
    if(overlay.hasClass('open')) {
      animate_menu('close');
    } else {
      animate_menu('open');
    }
  });

  overlay.on('click', function(e){
    if(overlay.hasClass('open')) {
      animate_menu('close');
    }
  });

  $('a[href="#"]').on('click', function(e){
    e.preventDefault();
  });

  function animate_menu(menu_toggle) {
    if(menu_toggle == 'open') {
      overlay.addClass('open');
      button.addClass('on');
      overlay.animate({opacity: 1}, speed);
      menu.animate({width: width, height: height}, speed);
    }

    if(menu_toggle == 'close') {
      button.removeClass('on');
      overlay.animate({opacity: 0}, speed);
      overlay.removeClass('open');
      menu.animate({width: "0", height: 0}, speed);
    }
  }
});
});

 //
 ///
 ////
 /////


 //Открытие формы регистрации

 $('.button-reg').on('click', function () {
     $('.overlay').fadeIn(200);
     $('.popup').fadeIn(200);
 });

 $('.button-login').on('click', function () {
     $('.overlay').fadeIn(200);
     $('.popup-login').fadeIn(200);
 });

$('.overlay').on('click', function () {
    $('.overlay').fadeOut(200);
    $('#overlay').fadeOut(200);
    $('.popupAll').fadeOut(200);
});

 $('.popup-close').on('click', function () {
     $('.overlay').fadeOut(200);
     $('#overlay').fadeOut(200);
     $('.popupAll').fadeOut(200);
 });

$('.input-login__remind').on('click', function () {
    $('.popup-login').fadeOut(200);
    $('.popup-remind').fadeIn(200);
});
















