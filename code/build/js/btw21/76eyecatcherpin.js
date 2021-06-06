$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: 'BereitBold',
  size: 15,
  anchor: 'middle',
};

const pin = {
  isLoaded: false,

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
    const pintext = draw.text($('#pintext').val()).font(pinfont).fill('#ffffff');

    // background
    const diameter = 1.35 * Math.max(pintext.rbox().w, pintext.rbox().h);
    const pinbackground = draw.circle(diameter)
      .fill('#f06464');

    pintext.move((diameter - pintext.rbox().w) / 2, (diameter - pintext.rbox().h) / 2);

    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);

    pin.svg.rotate(-9, draw.width(), pin.svg.y());

    pin.svg.move($('#pinX').val(), $('#pinY').val());
    pin.svg.front();
    pin.resize();
  },

  resize() {
    const eyecatchersize = $('#eyecatchersize').val();
    pin.svg.size(eyecatchersize);
  },

  bounce() {

  },
};

$('#pintext').bind('input propertychange', pin.draw);
$('#eyecatchersize').bind('input propertychange', pin.resize);
