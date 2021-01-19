$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: 'ArvoGruen',
  size: 15,
  anchor: 'left',
  weight: 300,
};

const pinurlfont = {
  family: 'Arvo',
  size: 13,
  anchor: 'left',
  weight: 300,
};

const pin = {
  isLoaded: false,

  svg: draw.text(''),

  draw() {
    $('#eyecatchersize').prop('disabled', ($('#pintext').val().length === 0));

    const countLines = ($('#pintext').val().match(/\n/g) || []).length; // start with 0

    if (countLines > 1) {
      $('#pintext').val($('#pintext').val().replace(/\n.*$/, ''));
    }

    pin.svg.remove();
    pin.svg = draw.group();
    if ($('#pintext').val() === '') return;

    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragmove.namespace', (e) => {
      const { handler, box } = e.detail;
      e.preventDefault();

      const { y } = box;

      handler.move(draw.width() - pin.svg.width(), y);
    });
    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const pintext = draw.text($('#pintext').val()).font(pinfont).fill('#ffffff');

    // background
    const pinwidth = pintext.rbox().w + 40 + (countLines * 20);
    const pinheight = pintext.rbox().h + 20;

    const bgColor = $('#pinColor').val();
    const pinbackground = draw.polygon([
      [0, 0],
      [pinwidth, 0],
      [pinwidth, pinheight],
      [0, pinheight],
      [pinheight * 0.5 * 0.41, pinheight * 0.5],
    ]);
    pinbackground.fill(bgColor);

    pintext.move(28 + (countLines * 10), 9);
    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    const pinurl = draw.text($('#pinurl').val()).font(pinurlfont).fill('#ffffff');
    pinurl.move(28 + (countLines * 10), pinheight + 8);

    // add in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);
    pin.svg.add(pinurl);

    pin.svg.move(draw.width() - pin.svg.width(), $('#pinY').val());
    const eyecatchersize = $('#eyecatchersize').val() / 100;
    pin.svg.scale(eyecatchersize, eyecatchersize, draw.width(), $('#pinY').val());

    pin.svg.front();
  },

  bounce() {

  },
};

$('#pintext, #pinurl, #eyecatchersize').bind('input propertychange', pin.draw);
