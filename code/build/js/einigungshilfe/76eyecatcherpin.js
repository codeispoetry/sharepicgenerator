$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pin = {
  isLoaded: false,

  font: {
    anchor: 'middle',
    size: 15,
  },

  svg: draw.text(''),

  draw() {
    $('#eyecatchersize').prop('disabled', ($('#pintext').val().length === 0));

    pin.svg.remove();
    pin.svg = draw.group();
    if ($('#pintext').val() === '') return;

    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const family = $('#eyecatcherfont').val();
    const pintext = draw.text($('#pintext').val()).font(Object.assign(pin.font, { family })).fill('#285F96');

    // background
    const pinwidth = pintext.rbox().w;
    const pinheight = pintext.rbox().h;

    const diameter = 1.45 * Math.max(pinwidth, pinheight);

    const pinbackground = draw.circle(diameter).fill($('#eyecatcherbackgroundcolor').val());

    pintext.move((diameter - pinwidth) * 0.5, (diameter - pinheight) * 0.5);
    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);

    pin.svg.move($('#pinX').val(), $('#pinY').val());

    const eyecatchersize = $('#eyecatchersize').val() / 100;
    pin.svg.scale(eyecatchersize, eyecatchersize);

    pin.svg.front();

    config.user.prefs.eyecatcherbackgroundcolor = $('#eyecatcherbackgroundcolor').val();
    setUserPrefs();
  },

  bounce() {

  },
};

$('#pintext, #eyecatchersize, #eyecatcherbackgroundcolor, #eyecatcherfont').bind('input propertychange', pin.draw);

$(document).ready(() => {
  if (config.user.prefs.eyecatcherbackgroundcolor) {
    $('#eyecatcherbackgroundcolor').val(config.user.prefs.eyecatcherbackgroundcolor);
  }
});
