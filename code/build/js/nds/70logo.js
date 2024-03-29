const logo = {
  loaded: false,
  svg: draw.image('/assets/btw21/logo.svg', () => {
    logo.loaded = true;
  }),

  draw() {
    logo.svg
      .move($('#logoX').val(), $('#logoY').val())
      .addClass('draggable');
    logo.resize($('#logosize').val());

    logo.svg.on('dragend.namespace', function logoDragEnd() {
      $('#logoX').val(Math.round(this.x()));
      $('#logoY').val(Math.round(this.y()));
    });
  },

  setSize(w) {
    if (!logo.loaded) {
      return false;
    }
    logo.svg.size(w, null);
    return true;
  },

  resize(percent) {
    if (config.layout === 'area') {
      return;
    }

    let newPercent = parseInt(percent, 10);
    newPercent = Math.min(100, newPercent);
    newPercent = Math.max(1, newPercent);

    const width = draw.width() * newPercent * 0.01;
    logo.svg.size(width, width);
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
