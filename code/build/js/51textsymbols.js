$(document).ready(() => {
  $('.special-chars span').bind('click', function () {
    $('#text').val($('#text').val() + $(this).html()).trigger('propertychange');
  });
});
