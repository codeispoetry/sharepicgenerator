$('.close').click(closeOverlay);

function closeOverlay() {
  const initScale = 0.4;

  $('head meta[name="viewport"]').attr('content', `width=800, initial-scale=${initScale}`);
  $('.overlay.active').removeClass('active');
}
closeOverlay();
