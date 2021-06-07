/* eslint-disable no-undef */
const area = {
  svg: draw.text(''),
  greenBackground: draw.circle(0),
  logo: draw.circle(0),
  colors: ['#ffffff', '#ffffff'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'BereitBold',
    size: 6,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'area') {
      return;
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

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

          color = area.colors[style];
          if (style === 0) {
            color = textColors[$('#textColor').val()];
          }

          add.tspan(values[i]).fill(color).font(
            Object.assign(area.font, { family: fontfamily }),
          );

          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });

      t.y(y);

      y += (t.rbox().h) + area.linemargin;

      lineBeginsY[index] = y;
      linesRendered[index] = t;
      text.svg.add(t);
    });

    // text below the line
    if ($('#textafter').val()) {
      const textafterParts = $('#textafter').val().split(/\[|\]/);
      let style = 1;
      const textafter = draw.text((add) => {
        for (let i = 0; i < textafterParts.length; i++) {
          style = (style === 0) ? 1 : 0;
          add.tspan(textafterParts[i]).fill('#ffffff').font(area.fontoutsidelines);
          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });
      textafter.x(0).dy(text.svg.height() + 6);

      text.svg.add(textafter);
    }

    eraser.front();
    showActionDayHint();

    text.svg.size(parseInt($('#textsize').val(), 10));

    const areaMargin = 30;
    const areaUpper = draw.height() - text.svg.height() - areaMargin;
    text.svg.move(20, areaUpper);

    // green layer behind text
    area.greenBackground.remove();
    area.greenBackground = draw.rect(draw.width(), text.svg.height() + (2 * areaMargin))
      .y(areaUpper - areaMargin)
      .fill('#A0C864');
    text.svg.front();

    logo.svg.hide();
    area.logo.remove();
    area.logo = draw.image(logo.logoinfo.file, () => {
      area.logo.size(draw.width() * 0.2)
        .move(draw.width() * 0.7, areaUpper - areaMargin - area.logo.height() * 0.6);
    });
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext, #showclaim').bind('input propertychange', area.draw);
