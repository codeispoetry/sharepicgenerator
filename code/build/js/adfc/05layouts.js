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
    case 'floating':
      logo.draw();
      floating.draw();
      logo.svg.draggable(true);
      break;
    default:
  }

  $('.align-center-text').trigger('click');
}

$('.layout').click(showLayout);

$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
