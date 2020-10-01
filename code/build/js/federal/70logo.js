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
    },
    'logo-gruen': {
      file: '/assets/logos/logo-gruen.svg',
      widthFraction: 0.20,
      position: 'topright',
    },
    'sonnenblume-big': {
      file: '/assets/logos/sonnenblume.svg',
      widthFraction: 0.5,
      position: 'bottomleftOutside',
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

    this.svg = draw.image(this.logoinfo.file, () => {
      logo.isLoaded = true;
      logo.draw();
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
      case 'bottomleftOutside':
        x = -(width * 0.5) + 20;
        y = -20 + draw.height() - logo.svg.height() * 0.5;
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
  if ($(this).val() === 'custom') {
    $('#uploadlogo').click();
    return;
  }

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
