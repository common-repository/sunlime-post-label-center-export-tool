(function ($) {
  "use strict";
  var SPLC = SPLC || {};
  SPLC.repeater = function () {
    $(document).on('click', '.js-splc__add-entry', '', function () {
      var $this = $(this),
        nonce = $this.data('nonce'),
        name = $this.data('name');
      $this.addClass('is-loading');
      $.ajax({
        type: "post",
        url: plcAjaxVars.ajaxUrl,
        dataType: 'json',
        data: {action: 'splc_add_packets_row_ajax', name: name, nonce: nonce},
        success: function (response) {
          console.log(response);
          $this.removeClass('is-loading');
          $this.prev().append(response.data.html);
        },
        error: function (xhr, status, error) {
          $this.removeClass('is-loading');
        }
      });
    });
    $(document).on('click', '.js-splc__remove-entry', '', function () {
      var $this = $(this);
      $this.parent().remove();
    });
  };
  /* READY FUNCTION
    ============================= */

  $(function () {
    SPLC.repeater();
  });

})(jQuery);