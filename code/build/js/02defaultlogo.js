const defaultlogo = {
  loaded: false,
  svg: draw.image(config.defaultlogo, () => {
    defaultlogo.loaded = true;
  }),

  draw() {
    defaultlogo.svg
      .move($('#logoX').val(), $('#logoY').val())
      .addClass('draggable').draggable();
      defaultlogo.resize($('#logosize').val());

      defaultlogo.svg.on('dragend.namespace', function logoDragEnd() {
      $('#logoX').val(Math.round(this.x()));
      $('#logoY').val(Math.round(this.y()));
    });
  },

  setSize(w) {
    if (!defaultlogo.loaded) {
      return false;
    }
    defaultlogo.svg.size(w, null);
  },

  resize(percent) {
    let newPercent = parseInt(percent, 10);
    newPercent = Math.min(100, newPercent);
    newPercent = Math.max(1, newPercent);

    const width = draw.width() * newPercent * 0.01;
    defaultlogo.svg.size(width, width);
  },
};

$('#logosize').bind('input propertychange', () => {
  defaultlogo.resize($('#logosize').val());
});

$('.align-center-logo').click(() => {
  const x = (draw.width() - logo.svg.width()) / 2;
  const y = (draw.height() - logo.svg.height()) / 2;

  $('#logoX').val(x);
  $('#logoY').val(x);
  defaultlogo.svg.move(x, y);
});
