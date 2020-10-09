$('.close').click(closeOverlay);

function closeOverlay() {
  const initScale = 0.4;

  $('head meta[name="viewport"]').attr('content', `width=800, initial-scale=${initScale}`);
  $('.overlay').hide();
  $('#canvas-area').show();
}


$('.closer').click(function doCloser() {
  // $($(this).data('target')).hide();
  $('.overlay').hide();
  $('#canvas-area').show();
});

$('.overlay-opener').click(function clickOpener() {
  const target = $(this).data('target');
  $('head meta[name="viewport"]').attr('content', 'width=device-width, initial-scale=1');
  $('.overlay').hide();
  $(`#${target}`).show();
  $('#canvas-area').slideUp();
  return false;
});
