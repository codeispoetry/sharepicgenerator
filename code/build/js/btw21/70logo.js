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

    width = draw.width() * newPercent * 0.01;
    logo.svg.size(width, null);
  },
};
logo.load();

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});
