const logo = {
  loaded: false,
  background: draw.circle(0),
  svg: draw.image('/assets/logos/sonnenblume21.svg', () => {
    logo.loaded = true;
  }),

  draw() {
    logo.svg
      .move($('#logoX').val(), $('#logoY').val());
    logo.resize($('#logosize').val());
  },

  resize(percent) {
    let newPercent = parseInt(percent, 10);
    newPercent = Math.min(100, newPercent);
    newPercent = Math.max(1, newPercent);

    const width = draw.width() * newPercent * 0.01;
    logo.svg.size(width, width);
    this.reposition($('#logoposition').val());

    logo.handleBackground();
  },

  handleBackground() {
    if ($('#showLogoBackground').prop('checked')) {
      const w = logo.svg.width();
      const h = logo.svg.height();
      logo.background.remove();
      logo.background = draw.polygon(`0, 0 ${w * 2},0 0, ${h * 2.1}`).fill('#009737');
      $('#logoposition').val('leftupper');
      logo.reposition('leftupperwithfond');
      logo.svg.front();
    } else {
      logo.background.remove();
    }
  },

  reposition(pos) {
    const left = -logo.svg.width() * 0.4;
    const right = draw.width() - (logo.svg.width() * 0.6);
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
      case 'leftupperwithfond':
        logo.svg.move(logo.svg.width() * 0.2, logo.svg.height() * 0.5);
        break;
      default:
        logo.svg.move(100, 100);
    }
  },
};

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});

$('#logoposition').on('input propertychange', () => {
  $('#showLogoBackground').prop('checked', false);
  logo.background.remove();
  logo.reposition($('#logoposition').val());
});

$('#showLogoBackground').on('change', () => {
  logo.handleBackground();
});

$('.align-center-logo').click(() => {
  const x = (draw.width() - logo.svg.width()) / 2;
  const y = (draw.height() - logo.svg.height()) / 2;

  $('#logoX').val(x);
  $('#logoY').val(x);
  logo.svg.move(x, y);
});
