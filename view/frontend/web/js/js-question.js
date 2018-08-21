require([
  'jquery',
  'jquery/ui',
  'jquery/validate',
  'mage/translate'
], function ($, mageTemplate) {
  "use strict";
    $(document).ready(function () {
            var ajaxUrl = $('.ajaxUrl').val();
            var selector = null;          
            $(document).on('click', '.btn', function () {
                  var formData = new FormData();
                  formData.append('type', 1);
                  $.ajax({
                        url: ajaxUrl,
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            $('.successMessage').css('display','block');
                            $('.buttonsForLike').css('display','none');
                        }
                  });
            });
    });
});
