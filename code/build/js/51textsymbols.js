$(document).ready(() => {
  $('.special-chars li').bind('click', function () {
    $('#text').val($('#text').val() + $(this).html()).trigger('propertychange');
  });
});
