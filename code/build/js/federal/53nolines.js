const nolines = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffffff', '#ffee00'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'ArvoGruen',
    size: 6,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'nolines') {
      return;
    }

    text.svg.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().addClass('draggable').attr('id', 'svg-text').draggable();

    text.svg.on('dragend.namespace', function dragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
      text.bounce();
      text.positionGrayBackground();
    });

    let y = 0;

    // let lines = '„' + $('#text').val() + '“';

    let lines = $('#text').val().toUpperCase();
    const quotationMarks = ['„', '“'];
    let qmI = 0;
    while ((lines.match(/"/g) || []).length) {
      lines = lines.replace(/"/, quotationMarks[qmI]);
      qmI = (qmI + 1) % 2;
    }

    lines = lines.replace(/\n$/, '').split(/\n/);
    const fontfamily = 'ArvoGruen';

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

          color = nolines.colors[style];
          if (style === 0) {
            color = textColors[$('#textColor').val()];
          }

          add.tspan(values[i]).fill(color).font(
            Object.assign(nolines.font, { family: fontfamily }),
          );

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.y(y);

      y += (t.rbox().h) + nolines.linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      text.svg.add(t);
    });

    // add lower line
    let lineafter;
    if ($('#textafter').val().length > 0) {
      lineafter = draw.rect(10, 8)
        .fill('#E6007E').dy(text.svg.height());
      text.svg.add(lineafter);
    }

    // text below the line
    const textafterParts = $('#textafter').val().toUpperCase().split(/\[|\]/);
    let style = 1;
    const textafter = draw.text((add) => {
      for (let i = 0; i < textafterParts.length; i++) {
        style = (style === 0) ? 1 : 0;
        add.tspan(textafterParts[i]).fill('#ffffff').font(nolines.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textafter.dx(2).dy(text.svg.height() - 2);

    // make background the same width as the text
    lineafter.width(textafter.bbox().width + 2);

    text.svg.add(textafter);

    // text above the line
    const textbeforeParts = $('#textbefore').val().toUpperCase().split(/\[|\]/);
    const textbefore = draw.text((add) => {
      for (let i = 0; i < textbeforeParts.length; i++) {
        style = (style === 0) ? 1 : 0;
        add.tspan(textbeforeParts[i]).fill('#FEEE00').font(nolines.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textbefore.dx(2).dy(text.svg.y() - 0.7);
    text.svg.add(textbefore);

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
    text.positionGrayBackground();
  },

};

$('#text, #textafter, #textsize, #graybehindtext').bind('input propertychange', nolines.draw);
