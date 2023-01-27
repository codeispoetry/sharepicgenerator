/* eslint-disable no-unused-vars */
/* eslint-disable no-undef */
function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  basic.draw();
  text.draw();
  nolines.draw();
  quote.draw();
  invers.draw();
 
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

  text.svg.on('dragmove.namespace', function dragMove() {
  
    const centerX = this.x() + (this.width() / 2);
    const centerY = this.y() + (this.height() / 2);
    const snapDistance = 5;

  });
}
$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
