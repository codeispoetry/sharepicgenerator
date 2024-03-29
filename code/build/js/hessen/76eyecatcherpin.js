$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

const pinfont = {
  family: 'NeueHaas',
  size: 15,
  anchor: 'middle',
  leading: '1em',
  weight: 'normal',
};

const pin = {
  isLoaded: false,

  svg: draw.text(''),
  template: draw.circle(0),

  draw() {
    //$('#eyecatchersize').prop('disabled', ($('#pintext').val().length === 0));

    pin.svg.remove();
    pin.svg = draw.group();
    if ($('#pintext').val() === '') return;

    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragstart.namespace', function () {
      undo.save();
    });

    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const pintext = draw.text($('#pintext').val()).font(pinfont).fill('#03523D');

    // background
    const diameter = 1.3 * Math.max(pintext.rbox().w, pintext.rbox().h);
    const pinbackground = draw.circle(diameter)
      .fill('#FFFFFF');

    const pinInnerBorderDistance = 3;
    const pinInnerBorder = draw.circle(diameter - 2 * pinInnerBorderDistance)
        .move(pinInnerBorderDistance, pinInnerBorderDistance)
        .stroke({ width: 1, color:'#03523D' })
        .fill('#FFFFFF')

    pintext.move((diameter - pintext.rbox().w) / 2, (diameter - pintext.rbox().h) / 2);
    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pinInnerBorder);
    pin.svg.add(pintext);

    pin.svg.move($('#pinX').val(), $('#pinY').val());
    pin.svg.front().show();
    pin.template.hide();
    $('#eyecatchertemplate').val('custom');
    pin.resize();

   // pin.svg.rotate(-9);
  },

  setSize(w) {
    pin.svg.size(w, null);
  },

  resize() {
    const eyecatchersize = $('#eyecatchersize').val();
    pin.svg.size(eyecatchersize);
    pin.template.size(eyecatchersize);
  },

 

  bounce() {

  },

  front() {
    if (!$('#eyecatchertemplate').val()) {
      return;
    }

    if ($('#eyecatchertemplate').val() === 'custom') {
      pin.svg.front();
      return;
    }

    pin.template.front();
  },
};

$('#pintext').bind('input propertychange', pin.draw);
$('#eyecatchersize').bind('input propertychange', pin.resize);

$('#pintext, #eyecatchersize').on('change', () => {
  undo.save();
});

$('.align-center-eyecatcher').click(() => {
  $('#pinX').val((draw.width() - pin.svg.width()) / 2);
  $('#pinY').val((draw.height() - pin.svg.height()) / 2);
  pin.draw();
  undo.save();
});
