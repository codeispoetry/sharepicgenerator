function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  // this better with trigger
  quote.draw();
  text.draw();
  nolines.draw();
  invers.draw();
}

$('.layout').click(showLayout);
