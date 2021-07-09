const logo = {
  loaded: false,
  svg: draw.image('/assets/logos/sonnenblume21.svg', () => {
    logo.loaded = true;
  }),

  draw() {
    console.log("draw logo")
    logo.svg
      .move($('#logoX').val(), $('#logoY').val())
      .addClass('draggable')
      .draggable();

    logo.resize($('#logosize').val());

    logo.svg.on('dragend.namespace', function logoDragEnd() {
      $('#logoX').val(Math.round(this.x()));
      $('#logoY').val(Math.round(this.y()));
      logo.svg.draggable(false);
    });
  },

  resize(percent) {
    if (config.layout === 'area') {
      return;
    }

    let newPercent = parseInt(percent, 10);
    newPercent = Math.min(100, newPercent);
    newPercent = Math.max(1, newPercent);

    const width = draw.width() * newPercent * 0.01;
    logo.svg.size(width, null);
  },
};

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});

$('.align-center-logo').click(() => {
  const x = (draw.width() - logo.svg.width()) / 2;
  const y = (draw.height() - logo.svg.height()) / 2;

  $('#logoX').val(x);
  $('#logoY').val(x);
  logo.svg.move(x, y);
});
