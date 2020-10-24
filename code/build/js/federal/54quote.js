const quote = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffffff', '#ffee00'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'middle',
    leading: '1.0em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'Arvo',
    size: 10,
    anchor: 'middle',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'quote') {
      return;
    }
    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    textDragging();

    let y = 0;

    // let lines = '„' + $('#text').val() + '“';

    let lines = $('#text').val();
    const quotationMarks = ['„', '“'];
    let qmI = 0;
    while ((lines.match(/"/g) || []).length) {
      lines = lines.replace(/"/, quotationMarks[qmI]);
      qmI = (qmI + 1) % 2;
    }

    lines = lines.replace(/\n$/, '').split(/\n/);
    const fontfamily = 'Arvo';

    const lineBeginsY = [];
    const linesRendered = [];
    let color;

    lines.forEach((value, index) => {
      let style = 1;

      // the main text
      const values = value.split(/\[|\]/);

      const t = draw.text((add) => {
        for (let i = 0; i < values.length; i++) {
          style = (style === 0) ? 1 : 0;

          color = quote.colors[style];
          if (style === 0) {
            color = textColors[$('#textColor').val()];
          }

          add.tspan(values[i]).fill(color).font(Object.assign(quote.font, { family: fontfamily }));

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.y(y);

      y += (t.rbox().h) + quote.linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      text.svg.add(t);
    });

    // add lower line
    if ($('#textafter').val().length > 0) {
      const lineWidth = text.svg.width() * 0.5;
      const lineOffset = (text.svg.width() - lineWidth) / 2;
      const lineafter = draw.rect(lineWidth, 1)
        .fill(color).dx(-1 * lineOffset).dy(text.svg.height() + 4);
      text.svg.add(lineafter);
    }

    // text below the line
    const textafterParts = $('#textafter').val().toUpperCase().split(/\[|\]/);
    let style = 1;
    const textafter = draw.text((add) => {
      for (let i = 0; i < textafterParts.length; i++) {
        style = (style === 0) ? 1 : 0;
        add.tspan(textafterParts[i]).fill(text.colors[style]).font(quote.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textafter.dy(text.svg.height() + 12);

    text.svg.add(textafter);

    // gray layer behind text
    text.grayBackground.remove();
    if ($('#graybehindtext').prop('checked')) {
      const grayGradient = draw.gradient('radial', (add) => {
        add.stop({ offset: 0, color: '#000', opacity: 0.9 });
        add.stop({ offset: 0.9, color: '#000', opacity: 0.0 });
      });
      grayGradient.from(0.5, 0.5).to(0.5, 0.5).radius(0.5);

      text.grayBackground = draw.rect(text.svg.width(), text.svg.height())
        .fill({ color: grayGradient, opacity: 0.3 })
        .back();
    }

    text.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10)).size(parseInt($('#textsize').val(), 10));
    eraser.front();
    showActionDayHint();
    text.positionGrayBackground();
  },

};

$('#text, #textafter, #textsize, #graybehindtext').bind('input propertychange', quote.draw);
