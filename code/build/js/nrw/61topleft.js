$('#topleft').focusout(function () {
  config.user.prefs.topleft = $(this).val().replace(/\n/g, '%20');
  setUserPrefs();
});

$(document).ready(() => {
  if (config.user.prefs.topleft) {
    $('#topleft').val(config.user.prefs.topleft.replace(/%20/g, "\n"));
  } else {
    $('#topleft').val('');
  }
});

const topleft = {
  svg: draw.text(''),
  sizes: [30, 20],
  yPos: [15, 51],

  draw() {
    topleft.svg.remove();
    topleft.svg = draw.group();

    const lines = $('#topleft').val().replace(/\n$/, '')
      .split(/\n/)
      .splice(0, 2);

    lines.forEach((value, index) => {
      const line = draw.text(value)
        .font({ family: 'BereitBold', size: topleft.sizes[index] })
        .move(20, topleft.yPos[index])
        .fill('#ffffff')
        .front();

      topleft.svg.add(line);
    });
  },
};

$('#topleft').bind('input propertychange', topleft.draw);
