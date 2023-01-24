/* eslint-disable no-undef */
function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();
  logo.draw();
  console.log("layout 16")
  floating.draw();
  logo.svg.draggable(true);

 
}

$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
