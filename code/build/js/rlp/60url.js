const url = {
  svg: draw.circle(0),

  draw() {
    url.svg.remove();
    url.svg = draw.text($('#url').val())
      .font({ family: 'ArvoGruen', size: 14 })
      .fill('white').move(20, draw.height() - 30);
  },
};

$('#url').bind('input propertychange', url.draw);

$('#url').focusout(function () {
  config.user.prefs.url = $(this).val();
  setUserPrefs();
});

$(document).ready(() => {
  if (config.user.prefs.url) {
    $('#url').val(config.user.prefs.url);
  } else {
    $('#url').val('gruene-rlp.de');
  }
});
