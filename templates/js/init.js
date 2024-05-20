$(function () {

  $('.button-collapse').sideNav();

  $('.modal').modal({
    ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
      $("#username").focus();
    }
  });
}); // end of document ready

function isEmpty(value) {
  return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}