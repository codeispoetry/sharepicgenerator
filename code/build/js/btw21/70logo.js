/* eslint-disable no-undef */
const logofont = {
  family: 'FuturaCondensedExtraBold',
  size: 78,
  anchor: 'left',
};

const logo = {
  isLoaded: false,
  config: {
    sonnenblume21: {
      file: '/assets/logos/sonnenblume21.svg',
      widthFraction: 0.1,
    },
  },

  load() {
    const whichLogo = 'sonnenblume21';
    if (logo.svg) logo.svg.remove();
    logo.isLoaded = false;

    if (whichLogo === 'void') {
      return false;
    }

    this.logoinfo = this.config[whichLogo];

    $('#logosize').val(this.logoinfo.widthFraction * 100);

    this.svg = draw.group().attr('id', 'svg-logo');
    const logofile = draw.image(this.logoinfo.file, () => {
      logo.isLoaded = true;
      logo.svg.add(logofile);

      setTimeout(logo.draw, 100); // with no timeout, error at hard reload of page
    });
    return true;
  },

  draw() {
    if (!logo.isLoaded) return false;

    if (logo.svg.width() === 0) return false;

    // let width = Math.max(50, draw.width() * logo.logoinfo.widthFraction);
    const width = draw.width() * logo.logoinfo.widthFraction;
    logo.svg.addClass('draggable').draggable();
    logo.svg.size(width, null);
    logo.svg.move(draw.width() * 0.6, draw.height() * 0.3);

    return true;
  },

  resize(percent) {
    let newPercent = parseInt(percent, 10);
    newPercent = Math.min(100, newPercent);
    newPercent = Math.max(1, newPercent);

    logo.logoinfo.widthFraction = newPercent / 100;
    logo.draw();
  },
};
logo.load();

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});
