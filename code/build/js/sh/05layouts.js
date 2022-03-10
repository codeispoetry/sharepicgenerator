/* eslint-disable no-undef */
function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  switch (config.layout) {
    case 'area':
      area.draw();
      break;
    case 'floating':
      floating.draw();
      logo.draw();
      break;
    default:
  }
}

$('.layout').click(showLayout);

$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
