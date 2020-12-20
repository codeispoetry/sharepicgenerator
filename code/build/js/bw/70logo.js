const logofont = {
  family: 'FuturaCondensedExtraBold',
  size: 78,
  anchor: 'left',
};

const logo = {
  isLoaded: false,
  config: {
    sonnenblume: {
      file: '/assets/logos/sonnenblume.svg',
      widthFraction: 0.1,
      position: 'topright',
    },
    'sonnenblume-weiss': {
      file: '/assets/logos/sonnenblume-weiss.svg',
      widthFraction: 0.1,
      position: 'topright',
    },
    frauenrechte: {
      file: '/assets/logos/frauenrechte.svg',
      widthFraction: 0.1,
      position: 'topright',
    },
    europa: {
      file: '/assets/logos/europa.svg',
      widthFraction: 0.15,
      position: 'topright',
    },
    regenbogen: {
      file: '/assets/logos/regenbogen.png',
      widthFraction: 0.1,
      position: 'topright',
    },
    'logo-weiss': {
      file: '/assets/logos/logo-weiss.svg',
      widthFraction: 0.2,
      position: 'topright',
      showChapter: true,
    },
    'logo-gruen': {
      file: '/assets/logos/logo-gruen.svg',
      widthFraction: 0.20,
      position: 'topright',
      showChapter: true,
    },
    'sonnenblume-big': {
      file: '/assets/logos/sonnenblume-viertel.svg',
      widthFraction: 0.28,
      position: 'bottomleftbig',
    },
    'logo-berlin-weiss': {
      file: '/assets/logos/berlin-weiss.svg',
      widthFraction: 0.2,
      position: 'topright',
    },
    'logo-berlin-gruen': {
      file: '/assets/logos/berlin-gruen.svg',
      widthFraction: 0.2,
      position: 'topright',
    },
    custom: {
      file: `/persistent/user/${config.user}/logo.png`,
      widthFraction: 0.2,
      position: 'topright',
    },
    fanleft: {
      file: '/assets/bw/faecher.png',
      widthFraction: 1,
      position: 'fanleft',
    },
    fancenter: {
      file: '/assets/bw/faecher.png',
      widthFraction: 1,
      position: 'fancenter',
    },
    fanright: {
      file: '/assets/bw/faecher.png',
      widthFraction: 1,
      position: 'fanright',
    },
  },

  load() {
    const whichLogo = $('#logoselect').val();
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

      // add text to logo
      if (this.logoinfo.showChapter && $('#logochapter').val()) {
        const chapter = draw.text($('#logochapter').val().toUpperCase()).font(logofont).fill('#ffffff').move(23, 1495);
        logo.svg.add(chapter);
      }

      setTimeout(logo.draw, 100); // with no timeout, error at hard reload of page
    });
    return true;
  },

  draw() {
    if (!logo.isLoaded) return false;

    // let width = Math.max(50, draw.width() * logo.logoinfo.widthFraction);
    const width = draw.width() * logo.logoinfo.widthFraction;
    logo.svg.size(width, null);
    let x;
    let y;

    switch (logo.logoinfo.position) {
      case 'bottomleft':
        x = 10;
        y = draw.height() - logo.svg.height() - 10 - 20;
        break;
      case 'bottomleftbig':
        x = 0;
        y = draw.height() - logo.svg.height();
        break;
      case 'fanleft':
        x = 0;
        y = 0;
        logo.svg.size(null, draw.height());
        break;
      case 'fancenter':
        logo.svg.size(null, draw.height());
        x = (draw.width() - logo.svg.width()) / 2;
        y = 0;
        break;
      case 'fanright':
        logo.svg.size(null, draw.height());
        x = draw.width() - logo.svg.width();
        y = 0;
        break;
      default:
        x = draw.width() - width - 10;
        y = 10;
    }
    logo.svg.move(x, y);

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

$('#logoselect').on('change', function changeLogo() {
  if ($(this).val() === 'deletecustomlogo') {
    // eslint-disable-next-line no-restricted-globals
    if (!confirm('Eigenes Logo wirklich dauerhaft löschen?')) {
      return;
    }

    $('#logoselect').val($('#logoselect option:first').val());

    $.post('/actions/delete.php', { action: 'logo', csrf: config.csrf })
      .done((response) => {
        const data = JSON.parse(response);
        if (data.error) {
          return false;
        }
        return true;
      });

    logo.load();
    return;
  }

  logo.load();
});

$('.uselogo').on('click', function clickUseLogo() {
  $('#logoselect').val($(this).data('logo'));
  logo.load();
});

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});

$('#logochapter').bind('input propertychange', () => logo.load());
