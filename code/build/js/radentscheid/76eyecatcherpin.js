$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: 'Bebas Neue',
  size: 15,
  anchor: 'middle',
  leading: '1em',
};

const pin = {
  isLoaded: false,

  svg: draw.text(''),

  draw() {
    $('#eyecatchersize').prop('disabled', ($('#pintext').val().length === 0));
    if ($('#pintext').val() === '') return;

    pin.svg.remove();
    pin.svg = draw.group();

    const countLines = ($('#pintext').val().match(/\n/g) || []).length; // start with 0

    if (countLines > 1) {
      $('#pintext').val($('#pintext').val().replace(/\n.*$/, ''));
    }


    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const pintext = draw.text($('#pintext').val()).font(pinfont).fill($('#pincolor').val());
    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // background
    const pinwidth = pintext.rbox().w + 10;
    const pinheight = pintext.rbox().h;

    const bgColor = $('#pinbgcolor').val();
    const deviation = -2.3;
    const pinbackground = draw.polygon([
      [0, 0],
      [pinwidth, 0],
      [pinwidth + deviation, pinheight],
      [deviation, pinheight],
    ]);
    pinbackground.fill(bgColor);

    pintext.move(5, 0);
    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);

    pin.svg.move($('#pinX').val(), $('#pinY').val());
    pin.svg.rotate(-7.5);

    pin.resize();

  },

  setSize(w) {
    pin.svg.size(w, null);
  },

  resize() {
    const eyecatchersize = $('#eyecatchersize').val();
    pin.svg.size(eyecatchersize);
  },

};

$('#pintext').bind('input propertychange', pin.draw);
$('#eyecatchersize').bind('input propertychange', pin.resize);

$('#eyecatchertemplate').on('change', pin.drawTemplate);

$('.align-center-eyecatcher').click(() => {
  $('#pinX').val((draw.width() - pin.svg.width()) / 2);
  $('#pinY').val((draw.height() - pin.svg.height()) / 2);
  pin.draw();
});
