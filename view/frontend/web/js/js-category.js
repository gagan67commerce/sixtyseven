
require([
  'jquery'
], function ($) {
  "use strict";

  $(document).ready(function () {
    //$('.faq-category').find('ol').find('li').first().addClass('active');
    $('.faqs-list .itemFaq > a').on('click', function () {
      if ($(this).parent().children('.descriptionFaq').css('display') !== 'none') {
        //$(this).parents('li').removeClass('active');
      } else {
        $(this).parents('.faq-category').find('ol li').removeClass('active');
        //$(this).parents('li').addClass('active');
      }
      return false;
    });
    $('.faq-category').find('ol li .read-more').click(function() {
      window.location.href = $(this).parent().find('a').attr('href');
    });
  });
});
