$('.overlay-opener').click(function () {
  const target = $(this).data('target');
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  $(`#${target}`).addClass('active');

  return false;
});
