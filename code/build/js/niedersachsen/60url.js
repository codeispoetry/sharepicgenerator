$('#url').focusout(function () {
  config.user.prefs.url = $(this).val();
  setUserPrefs();
});

$(document).ready(() => {
  if (config.user.prefs.url) {
    $('#url').val(config.user.prefs.url);
  } else {
    $('#url').val('');
  }
});

const url = {
  svg: draw.text(''),

  draw() {
    url.svg.remove();

    url.svg = draw.text($('#url').val())
        .font({family: 'BereitBold', size: 30 })
        .move(20, 15)
        .fill('#ffffff')
        .front();
  },
};

$('#url').bind('input propertychange', url.draw);
