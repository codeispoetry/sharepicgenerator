/* eslint-disable no-undef */
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
    size: 80,
  },
  fontoutsidelines: {
    family: 'BereitBold',
    size: 50,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'nolines') {
      return;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

   // textDragging();

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
    const fontfamily = 'BereitBold';

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
      lineafter = draw.rect(10, 55)
        .fill('#fee100').dy(text.svg.height());
      text.svg.add(lineafter);
    }

    // text below the line
    if ($('#textafter').val()) {
      const textafterParts = $('#textafter').val().split(/\[|\]/);
      let style = 1;
      const textafter = draw.text((add) => {
        for (let i = 0; i < textafterParts.length; i++) {
          style = (style === 0) ? 1 : 0;
          add.tspan(textafterParts[i]).fill('#105f32').font(nolines.fontoutsidelines);
          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });
      textafter.dx(4).dy(text.svg.height() - 5);

      // make background the same width as the text
      let paddingRight = 10;
      if (getBrowser() === 'Firefox') {
        paddingRight = 10;
      }
      lineafter.width(textafter.bbox().width + paddingRight);

      text.svg.add(textafter);
    }

    // text above the line
    const textbeforeParts = $('#textbefore').val().split(/\[|\]/);
    const textbefore = draw.text((add) => {
      for (let i = 0; i < textbeforeParts.length; i++) {
        add.tspan(textbeforeParts[i]).fill('#FEEE00').font(nolines.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textbefore.dx(2).dy(text.svg.y() - 0.7);
    text.svg.add(textbefore);

    eraser.front();
    showActionDayHint();

    //text.svg.size(parseInt($('#textsize').val(), 10));

    // gray layer behind text
    text.grayBackground.remove();

    text.grayBackground = draw.rect(draw.width(), text.svg.height() + 30)
      .y(draw.height() - text.svg.height() - 30)
      .fill('#a0c865')
      .back();
    background.svg.back();

    logo.svg.size(draw.width() * 0.25);
    logo.svg.move(draw.width() * 0.7, text.grayBackground.y() - (logo.svg.height() * 0.82));

    text.svg.move(10, draw.height() - text.svg.height() - 20);

    checkForOtherTenant();
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext').bind('input propertychange', nolines.draw);
