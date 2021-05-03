/* eslint-disable no-undef */
const nolines = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ff0000', '#ffee00'],
  lineheight: 20,
  linemargin: -17,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    family: 'Paralucent Condensed',
    weight: '900',
  },
  fontoutsidelines: {
    family: 'Paralucent Condensed',
    size: 11,
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

    const lineBeginsY = [];
    const linesRendered = [];
    let color;

    lines.forEach((value, index) => {
      let style = 1;

      // the main text
      const values = value.split(/\[|\]/);

      let fontsize = 20;
      let bgheight = 24;
      let linemargin = -8;

      if (value.startsWith('!')) {
        fontsize = 40;
        bgheight = 29;
        if (lines[index + 1].startsWith('!')) {
          linemargin = -18;
        } else {
          linemargin = -14;
        }
        values[0] = values[0].substring(1);
      }

      const t = draw.text((add) => {
        for (let i = 0; i < values.length; i++) {
          style = (style === 0) ? 1 : 0;

          color = nolines.colors[style];
          if (style === 0) {
            color = textColors[$('#textColor').val()];
          }
          color = '#01fd96'; // always neon green!

          add.tspan(values[i]).fill(color).font(
            Object.assign(nolines.font, { size: fontsize }),
          );

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      const x = -3 * index; // each line indents more to the left
      t.move(0, y);

      // green fond for each text line
      let paddingRight = 2;
      if (getBrowser() === 'Firefox') {
        paddingRight = 4;
      }
      const right = t.bbox().width + paddingRight;

      y += (t.rbox().h) + linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      text.svg.add(t);
    });

    const left = -20;
    const top = -10;
    const right = text.svg.width() + 30;
    const bottom = text.svg.height() + 10;

    const text2nd = draw.text($('#textafter').val().toUpperCase())
      .font(nolines.fontoutsidelines)
      .fill('#004542')
      .y(bottom + 2);
    text.svg.add(text2nd);
    text2nd.front();

    const greenfond1 = draw.polygon(`${left},${top} ${right},${top} ${right},${bottom} ${left},${bottom}`)
      .fill('#004542');
    text.svg.add(greenfond1);
    greenfond1.back();

    let dy2 = 5;
    if ($('#textafter').val()) {
      dy2 = 18;
    }
    const greenfond2 = draw.polygon(`${left},${top} ${right},${top} ${right},${bottom} ${left},${bottom}`)
      .fill('#01fd96').dx(5).dy(dy2);
    text.svg.add(greenfond2);
    greenfond2.back();

    eraser.front();
    showActionDayHint();

    // gray layer behind text
    text.grayBackground.remove();
    if ($('#graybehindtext').prop('checked')) {
      const grayGradient = draw.gradient('radial', (add) => {
        add.stop({ offset: 0, color: $('#colorbehindtext').val(), opacity: 0.9 });
        add.stop({ offset: 0.9, color: '#000', opacity: 0.0 });
      });
      grayGradient.from(0.5, 0.5).to(0.5, 0.5).radius(0.5);

      text.grayBackground = draw.rect(text.svg.width(), text.svg.height())
        .fill({ color: grayGradient, opacity: 0.3 })
        .back();
    }
    text.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10)).size(parseInt($('#textsize').val(), 10));
    text.positionGrayBackground();

    text.svg.skew(0, -12);
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext').bind('input propertychange', nolines.draw);
