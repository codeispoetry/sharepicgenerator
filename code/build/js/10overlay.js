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

