function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  // this better with trigger
  background.svg.unmask();
  quote.draw();
  inverted.draw();
  text.draw();
  nolines.draw();
}

$('.layout').click(showLayout);
