const logo = {
  isLoaded: false,
  config: {
    sonnenblume: {
      file: '/assets/einigungshilfe/logo.svg',
      widthFraction: 0.1,
      position: 'topright',
    },
    custom: {
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

    this.svg = draw.group().attr('id', 'svg-logo');
    const logofile = draw.image(this.logoinfo.file, () => {
      logo.isLoaded = true;
      logo.svg.add(logofile);

      setTimeout(logo.draw, 100); // with no timeout, error at hard reload of page
    });
    return true;
  },

  loadTmp(file) {
    if (logo.svg) logo.svg.remove();
    logo.isLoaded = false;

    this.logoinfo = {
      widthFraction: 0.2,
    };

    this.svg = draw.group().attr('id', 'svg-logo');
    const logofile = draw.image(file, () => {
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
    logo.svg.size(width, null);
    let x;
    let y;

    switch ($('#logoposition').val()) {
      case 'topleft':
        x = 10;
        y = 30;
        break;
      case 'topcenter':
        x = (draw.width() - logo.svg.width()) / 2;
        y = 30;
        break;
      case 'topright':
        x = (draw.width() - logo.svg.width()) - 10;
        y = 30;
        break;
      case 'bottomleft':
        x = 10;
        y = draw.height() - logo.svg.height() - 10;
        break;
      case 'bottomcenter':
        x = (draw.width() - logo.svg.width()) / 2;
        y = draw.height() - logo.svg.height() - 10;
        break;
      case 'bottomright':
        x = (draw.width() - logo.svg.width()) - 10;
        y = draw.height() - logo.svg.height() - 10;
        break;
      default:
        x = draw.width() - width - 10;
        y = 10;
    }

    logo.svg.move(x, y);
    config.user.prefs.logoPosition = $('#logoposition').val();
    setUserPrefs();

    return true;
  },

  resize(percent) {
    if (!logo.isLoaded) {
      return;
    }
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
    logo.config.custom.file = $('#logoselect option:selected').data('file');
    logo.load();
  }

  config.user.prefs.lastLogo = $(this).val();

  setUserPrefs();

  logo.load();
});

$('#logosize').bind('input propertychange', () => {
  logo.resize($('#logosize').val());
});

$(document).ready(() => {
  if (config.user.prefs.lastLogo) {
    if (config.user.prefs.lastLogo === 'custom' && $('#logoselect option[value=custom]').length === 0) {
      config.user.prefs.lastLogo = $('#logoselect option:first').val();
    } else {
      logo.config.custom.file = $('#logoselect option[value=custom]').data('file');
    }

    $('#logoselect').val(config.user.prefs.lastLogo);

    if (config.user.prefs.logoPosition) {
      $('#logoposition').val(config.user.prefs.logoPosition);
    }

    logo.load();
  }

  $('.delete-logo').click(function deleteLogo() {
    // eslint-disable-next-line no-restricted-globals
    if (!confirm('Logo wirklich löschen?')) {
      return false;
    }
    const file = $(this).data('file');

    $.post('/actions/delete.php', { action: 'logo', csrf: config.csrf, file })
      .done((response) => {
        const data = JSON.parse(response);

        if (data.error) {
          alert(data.error.code);
          return false;
        }
        return true;
      });

    $('#logoselect').val($('#logoselect option:first').val());
    $(this).parents('.samplesharepic').fadeOut().hide();

    return true;
  });
});

$('#logoposition').bind('input propertychange', logo.draw);
