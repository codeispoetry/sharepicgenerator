$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: 'FuturaCondensedExtraBold',
  size: 15,
  anchor: 'left',
  weight: 300,
  leading: 1.4,
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

    // text
    // eslint-disable-next-line prefer-template
    const pintext = draw.text(' ' + $('#pintext').val().toUpperCase())
      .font(pinfont)
      .fill('#ffffff')
      .dx(-3);

    // background
    let paddingRight = 2;
    // eslint-disable-next-line no-undef
    if (getBrowser() === 'Firefox') {
      paddingRight = 4;
    }
    let pinwidth = 100 + paddingRight;
    const pinheight = 18;

    let yOffset = 6;
    const pinbackground1stLine = draw.polygon([
      [0, yOffset + 0],
      [pinwidth + 3, yOffset + 0],
      [pinwidth, yOffset + pinheight],
      [-3, yOffset + pinheight],
    ]).fill('#e6007e');

    yOffset = 27;
    pinwidth = 40 + paddingRight;
    const pinbackground2ndLine = draw.polygon([
      [-3, yOffset + 0],
      [pinwidth + 3, yOffset + 0],
      [pinwidth, yOffset + pinheight],
      [-6, yOffset + pinheight],
    ]).fill('#e6007e');

    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground1stLine);
    pin.svg.add(pinbackground2ndLine);
    pin.svg.add(pintext);

    pin.svg.move(draw.width() - pin.svg.width() - 20, 220);
    const eyecatchersize = 2.5; //$('#eyecatchersize').val() / 100;
    pin.svg.scale(eyecatchersize, eyecatchersize, draw.width(), $('#pinY').val());
    pin.svg.rotate(-6.5, draw.width(), pin.svg.y());

    pin.svg.front();
  },

  bounce() {

  },
};

$('#pintext, #eyecatchersize').bind('input propertychange', pin.draw);
