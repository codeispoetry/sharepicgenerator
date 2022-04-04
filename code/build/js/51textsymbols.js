$(document).ready(() => {
  $('.text-symbol').bind('click', function () {
    $('#text').val($('#text').val() + $(this).data('symbol')).trigger('propertychange');
  });
});
