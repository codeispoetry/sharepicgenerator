const pin = {
  isLoaded: false,
  font: {
    family: 'GrueneType',
    size: 15,
    anchor: 'middle'
  },

  svg: draw.text(''),
  template: draw.circle(0),

  draw() {
    //$('#eyecatchersize').prop('disabled', ($('#pintext').val().length === 0));

    const lines = $('#pintext').val().replace(/\n$/, '').split(/\n/);


    $('select.depin').hide();
    pin.svg.remove();
    pin.svg = draw.group();
    if ($('#pintext').val() === '') return;

    pin.svg.addClass('draggable').draggable();

    pin.svg.on('dragend.namespace', () => {
      $('#pinX').val(Math.round(pin.svg.x()));
      $('#pinY').val(Math.round(pin.svg.y()));
    });

    // text
    const pintext = draw.group();
    let rows = [];
    let maxWidth = 0;

    lines.forEach((value, index) => {
      const size = $('#pinLineSize' + index).val();

      rows[index] = draw.text(value).fill('#f5f1e9')
        .font(
          Object.assign(
            pin.font, { size }
          ));

      maxWidth = Math.max(maxWidth, rows[index].rbox().w);

      $('select#pinLineSize' + index).show();
    });


    // move each line and put all together
    let yOffset = 0;
    lines.forEach((value, index) => {
      const size = $('#pinLineSize' + index).val();

      rows[index].x( (maxWidth - rows[index].rbox().w) / 2 );
      const y = -size * 0.25;
      rows[index].y( y + yOffset)

      const lineMargin = 1.3;
      yOffset += y + ( lineMargin * rows[index].rbox().height * 0.75);

      pintext.add(rows[index]);
    });


    // background
    const diameter = Math.max(pintext.rbox().w, pintext.rbox().h) / 0.7;
    const pinbackground = draw.circle(diameter).fill('#0ba1dd');


    pintext.move((diameter - pintext.rbox().w) / 2, (diameter - pintext.rbox().h) / 2);

    pintext.attr('xml:space', 'preserve').attr('style', 'white-space:pre');

    // and in reverse order
    pin.svg.add(pinbackground);
    pin.svg.add(pintext);

    pin.svg.move($('#pinX').val(), $('#pinY').val());
    pin.svg.front().show();

    pin.resize();

    pin.svg.rotate(-7);
  },

  setSize(w) {
    pin.svg.size(w, null);
  },

  resize() {
    const eyecatchersize = $('#eyecatchersize').val();
    pin.svg.size(eyecatchersize);
  },

  front() {
    pin.template.front();
  },
};

$('#pintext, .depin').bind('input propertychange', pin.draw);
$('#eyecatchersize').bind('input propertychange', pin.resize);
$('#pinsize').bind('input propertychange', () => {
  pin.draw();
});

$('#pintext, #eyecatchersize').on('change', () => {
  undo.save();
});

$('.align-center-eyecatcher').click(() => {
  $('#pinX').val((draw.width() - pin.svg.width()) / 2);
  $('#pinY').val((draw.height() - pin.svg.height()) / 2);
  pin.draw();
  undo.save();
});
