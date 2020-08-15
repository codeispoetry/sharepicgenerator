const logo = {
  isLoaded: false,
  config: {
    sonnenblume: {
      file: '/assets/logos/sonnenblume.svg',
      widthFraction: 0.1,
      position: 'bottomright',
    },
    'sonnenblume-weiss': {
      file: '/assets/logos/sonnenblume-weiss.svg',
      widthFraction: 0.1,
      position: 'bottomright',
    },
  },

  load() {
    whichLogo = $('#logoselect').val();
    if (logo.svg) logo.svg.remove();
    logo.isLoaded = false;

    if (whichLogo == 'void') {
      return false;
    }

    this.logoinfo = this.config[whichLogo];

    this.svg = draw.image(this.logoinfo.file, (event) => {
      logo.isLoaded = true;
      logo.draw();
    });
  },

  draw() {
    if (!logo.isLoaded) return false;

    const width = Math.max(50, draw.width() * logo.logoinfo.widthFraction);
    logo.svg.size(width);
    let x; let
      y;

    switch (logo.logoinfo.position) {
      case 'bottomleft':
        x = 10;
        y = draw.height() - logo.svg.height() - 10 - 20;
        break;
      case 'bottomright':
        x = draw.width() - width - 20;
        y = draw.height() - logo.svg.height() - 20;
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
  },
};
logo.load();

$('#logoselect').on('change', function () {
  if ($(this).val() == 'custom') {
    $('#uploadlogo').click();
    return;
  }

  if ($(this).val() == 'deletecustomlogo') {
    if (!confirm('Eigenes Logo wirklich dauerhaft löschen?')) {
      return;
    }

    $('#logoselect').val($('#logoselect option:first').val());

    $.post('/delete.php', { user: config.user, accesstoken: config.accesstoken })
      .done((data) => {
        const obj = JSON.parse(data);
        if (obj.error) {
          return false;
        }
      });

    logo.load();
    return;
  }

  logo.load();
});

$('.uselogo').on('click', function () {
  $('#logoselect').val($(this).data('logo'));
  logo.load();
});
