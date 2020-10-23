function showLayout() {
  config.layout = $('input[name=layout]:checked', '#pic').val();

  $('.showonly').hide();

  $(`.${config.layout}`).show();

  quote.draw();
  text.draw();
  nolines.draw();
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
    $('.gridline-active').removeClass('gridline-active');
  });

  text.svg.on('dragmove.namespace', function dragMove() {
    $('.gridline-active').removeClass('gridline-active');

    const centerX = this.x() + (this.width() / 2);
    const centerY = this.y() + (this.height() / 2);
    const snapDistance = 5;

    if (Math.abs((draw.width() * 0.5) - centerX) < snapDistance) {
      $('#grid-vertical-center').addClass('gridline-active');
    }
    if (Math.abs((draw.width() * 0.382) - centerX) < snapDistance) {
      $('#grid-vertical-left').addClass('gridline-active');
    }
    if (Math.abs((draw.width() * 0.618) - centerX) < snapDistance) {
      $('#grid-vertical-right').addClass('gridline-active');
    }

    if (Math.abs((draw.height() * 0.5) - centerY) < snapDistance) {
      $('#grid-horizontal-center').addClass('gridline-active');
    }
    if (Math.abs((draw.height() * 0.382) - centerY) < snapDistance) {
      $('#grid-horizontal-upper').addClass('gridline-active');
    }
    if (Math.abs((draw.height() * 0.618) - centerY) < snapDistance) {
      $('#grid-horizontal-lower').addClass('gridline-active');
    }
  });
}
$('.addpictures').on('shown.bs.collapse', () => {
  $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
});
