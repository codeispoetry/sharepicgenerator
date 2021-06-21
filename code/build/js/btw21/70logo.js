const logo = {
  loaded: false,
  svg: draw.image('/assets/logos/sonnenblume21.svg', () => {
    logo.loaded = true;
    console.log("loaded")
  }),

  draw() {
    if (!logo.loaded) return false;

    if (logo.svg.width() === 0) return false;

    console.log("hi")
    // let width = Math.max(50, draw.width() * logo.logoinfo.widthFraction);
    const width = draw.width() * logo.logoinfo.widthFraction;
    logo.svg.addClass('draggable').draggable();
    logo.svg.size(width, null);

    logo.svg.move(parseInt($('#logoX').val(), 10), parseInt($('#logoY').val(), 10));

    logo.svg.on('dragend.namespace', function dragEnd() {
      $('#logoX').val(Math.round(this.x()));
      $('#logoY').val(Math.round(this.y()));
    });

    logo.resize($('#logosize').val());

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
    logo.svg.size(width, null);
  },
};

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});
