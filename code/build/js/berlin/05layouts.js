/* eslint-disable no-undef */
function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  switch (config.layout) {
    case 'area':
      area.draw();
      logo.svg.draggable(false);
      break;
    case 'berlintext':
      berlintext.draw();
      logo.draw();
      logo.svg.draggable(true);
      break;
    default:
  }
}

$('.layout').click(showLayout);

$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
