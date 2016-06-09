/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire*/
(function (window, document, $) {

  var $html = $('html'),
    mobileOnly = "screen and (max-width:47.9375em)", // 767px.
    mobileLandscape = "(min-width:30em)", // 480px.
    tablet = "(min-width:48em)"; // 768px.

    // Enquire usage:
    // enquire.register(tablet, {
    //   match: function () {
    //     $(window).on('resize', hander).resize();
    //   },
    //   unmatch : function () {
    //     $(window).on('resize', hander);
    //   },
    // });

  // Add  functionality here.

  $( ".ion-ios-search-strong" ).on( "click", function() {
    if($(this).hasClass('hidden')){
      $(this).removeClass('avtive');
    }
    $(this).addClass('hidden').removeClass('avtive');
    $('.toggle-search .ion-close').addClass('avtive').removeClass('hidden');
    // $('.block-search-form-wrapper form').addClass('avtive');
    $('.block-search-form-wrapper form').show();
  });

  $(".ion-close").on( "click", function() {
    if($(this).hasClass('avtive')){
      $('.block-search-form-wrapper form').hide('fast');
      $(this).removeClass('avtive');
      $(this).addClass('hidden');
    }
    $('.toggle-search .ion-ios-search-strong').addClass('avtive').removeClass('hidden');
  });

  $('.box-service__items__img').matchHeight();

  $('.box-service__items__img').each(function (){
    var height_item = $(this).outerHeight();
    var height_img = $(this).find('img').height();
    console.log('height item' + height_item);
    console.log('height img' + height_img);
    var height_margin = height_item - height_img;
    $(this).find('img').css({'margin-top': height_margin});
  });

  $('.parallax-window').parallax({imageSrc: '../images/App2-Background-4.jpg'});

}(this, this.document, this.jQuery));


/* function custom equalheight */

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.footer-column');
});


$(window).resize(function(){
  equalheight('.footer-column');
});
