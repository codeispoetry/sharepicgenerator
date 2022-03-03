const logo = {
  loaded: false,
  svg: draw.image('/assets/logos/sonnenblume21.svg', () => {
    logo.loaded = true;
  }),

  draw() {
    logo.svg
      .move($('#logoX').val(), $('#logoY').val());
    logo.resize($('#logosize').val());
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
    this.reposition($('#logoposition').val());
  },

  reposition(pos) {
    const left = -logo.svg.width() / 2;
    const right = draw.width() - (logo.svg.width() / 2);
    const upper = -10;
    const bottom = draw.height() - logo.svg.height() + 10;
    const center = (draw.height() - logo.svg.height()) / 2;
    switch (pos) {
      case 'leftupper':
        logo.svg.move(left, upper);
        break;
      case 'leftcenter':
        logo.svg.move(left, center);
        break;
      case 'leftbottom':
        logo.svg.move(left, bottom);
        break;
      case 'rightupper':
        logo.svg.move(right, upper);
        break;
      case 'rightcenter':
        logo.svg.move(right, center);
        break;
      case 'rightbottom':
        logo.svg.move(right, bottom);
        break;
      default:
        logo.svg.move(100, 100);
    }
  },
};

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});

$('#logoposition').on('change', () => {
  logo.reposition($('#logoposition').val());
});

$('.align-center-logo').click(() => {
  const x = (draw.width() - logo.svg.width()) / 2;
  const y = (draw.height() - logo.svg.height()) / 2;

  $('#logoX').val(x);
  $('#logoY').val(x);
  logo.svg.move(x, y);
});
