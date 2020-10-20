const nolines = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['white', 'black', '#46962b', '#E6007E', '#FEEE00'],
  textColorIndex: 0,
  textbeforeColorIndex: 1,
  textafterColorIndex: 3,
  texthighlightColorIndex: 4,
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

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    textDragging();

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

          color = nolines.colors[nolines.textColorIndex];
          if (style === 1) {
            // eslint-disable-next-line prefer-destructuring
            color = nolines.colors[nolines.texthighlightColorIndex];
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

    // text below the line
    if ($('#textafter').val()) {
      const textafterParts = $('#textafter').val().toUpperCase().split(/\[|\]/);
      let style = 1;
      const textafter = draw.text((add) => {
        for (let i = 0; i < textafterParts.length; i++) {
          style = (style === 0) ? 1 : 0;
          add.tspan(textafterParts[i])
            .fill(nolines.colors[nolines.textafterColorIndex]).font(nolines.fontoutsidelines);
          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });
      textafter.dx(2).dy(text.svg.height() + 5);
      text.svg.add(textafter);
    }

    // text above the line
    const textbeforeParts = $('#textbefore').val().toUpperCase().split(/\[|\]/);
    const textbefore = draw.text((add) => {
      for (let i = 0; i < textbeforeParts.length; i++) {
        add.tspan(textbeforeParts[i])
          .fill(nolines.colors[nolines.textbeforeColorIndex]).font(nolines.fontoutsidelines);
        add.attr('xml:space', 'preserve');
        add.attr('style', 'white-space:pre');
      }
    });
    textbefore.dx(2).dy(text.svg.y() - 0.7);
    text.svg.add(textbefore);

    eraser.front();
    showActionDayHint();

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

$('#text, #textafter, #textbefore, #textsize, #graybehindtext').bind('input propertychange', nolines.draw);

$('.text-change-color').click(() => {
  nolines.textColorIndex += 1;
  nolines.textColorIndex %= nolines.colors.length;
  nolines.draw();
});

$('.textbefore-change-color').click(() => {
  nolines.textbeforeColorIndex += 1;
  nolines.textbeforeColorIndex %= nolines.colors.length;
  nolines.draw();
});

$('.textafter-change-color').click(() => {
  nolines.textafterColorIndex += 1;
  nolines.textafterColorIndex %= nolines.colors.length;
  nolines.draw();
});

$('.texthighlight-change-color').click(() => {
  nolines.texthighlightColorIndex += 1;
  nolines.texthighlightColorIndex %= nolines.colors.length;
  nolines.draw();
});
