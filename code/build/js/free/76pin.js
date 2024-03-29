/* This file resides in build/free. It is symlinked*/


$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: $('#pinFont').val(),
  size: 15,
  anchor: 'middle',
  leading: '1em',
};

const pin = {
  isLoaded: false,

  svg: draw.text(''),
  template: draw.circle(0),

  draw() {
   
    pin.svg.remove();
    pin.svg = draw.group();
    if ($('#pintext').val() === '') return;

    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const pintext = draw.text($('#pintext').val()).font(pinfont).fill($('#pincolor').val());

    // background
    const diameter = 1.25 * Math.max(pintext.rbox().w, pintext.rbox().h);
    const pinbackground = draw.circle(diameter)
      .fill($('#pinbgcolor').val());

    pintext.move((diameter - pintext.rbox().w) / 2, (diameter - pintext.rbox().h) / 2);

    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);

    pin.svg.move($('#pinX').val(), $('#pinY').val());
    pin.svg.front().show();
    pin.template.hide();
    pin.resize();

    //pin.svg.rotate(-9);
  },

  setSize(w) {
    pin.svg.size(w, null);
  },

  resize() {
    const eyecatchersize = $('#eyecatchersize').val();
    pin.svg.size(eyecatchersize);
    pin.template.size(eyecatchersize);
  },

  front() {
    pin.template.front();
  },
};

$('#pintext, #pinbgcolor').bind('input propertychange', pin.draw);
$('#eyecatchersize').bind('input propertychange', pin.resize);


$('.align-center-eyecatcher').click(() => {
  $('#pinX').val((draw.width() - pin.svg.width()) / 2);
  $('#pinY').val((draw.height() - pin.svg.height()) / 2);
  pin.draw();
});
