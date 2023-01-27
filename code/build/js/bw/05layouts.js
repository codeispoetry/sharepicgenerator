function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  text.draw();
  nolines.draw();
}

$('.layout').click(showLayout);

function textDragging() {
  if (!config.noTextDradAndDrop) {
    text.svg.addClass('draggable').draggable();
  }

  text.svg.draggable().on('beforedrag', (e) => {
    if (config.noTextDradAndDrop) {
      e.preventDefault();
    }
  });

  text.svg.on('dragend.namespace', function dragEnd() {
    $('#textX').val(Math.round(this.x()));
    $('#textY').val(Math.round(this.y()));
    text.bounce();
    text.positionGrayBackground();

  });

}
$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
