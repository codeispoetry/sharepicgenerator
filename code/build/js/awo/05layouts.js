/* eslint-disable no-undef */
function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  switch (config.layout) {
    case 'floating':
      logo.draw();
      floating.draw();
      break;
    default:
  }

  $('.align-center-text').trigger('click');
}

$('.layout').click(showLayout);

$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
