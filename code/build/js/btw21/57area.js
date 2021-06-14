/* eslint-disable no-undef */
const area = {
  svg: draw.text(''),
  greenBackground: draw.circle(0),
  logo: false,
  colors: ['#ffffff', '#ffffff'],
  lineheight: 20,
  linemargin: -4,
  areaMargin: 0,
  areaUpper: 0,
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
  logoDrawn: false,

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

    // text or claim below the line
    if ($('#showclaim').prop('checked')) { 
      const w = claimWidth;
      const h = 9;
      const claimFond = draw.polyline(`0,0 ${w},0 ${w},${h}, 0,${h}`).fill('#ffe100').skew([-9, 0]);
      const claimTextLine = draw.text(claimText)
        .fill('#145f32')
        .font(area.fontoutsidelines)
        .move(1, 1);
      const claim = draw.group();
      claim.add(claimFond);
      claim.add(claimTextLine);
      claim.y(text.svg.height());

      switch (area.align) {
        case 'middle':
          claim.x(-claim.width() / 2);
          break;
        case 'end':
          claim.x(-claim.width());
          break;
        default:
      }

      text.svg.add(claim);
    } else if ($('#textafter').val()) {
      const textafterParts = $('#textafter').val().split(/\[|\]/);
      let style = 1;
      const textafter = draw.text((add) => {
        for (let i = 0; i < textafterParts.length; i++) {
          style = (style === 0) ? 1 : 0;
          add.tspan(textafterParts[i]).fill('#ffffff').font(nolines.fontoutsidelines);
          add.attr('xml:space', 'preserve');
          add.attr('style', 'white-space:pre');
        }
      });
      textafter.dy(text.svg.height() + 6);
      switch (nolines.align) {
        case 'middle':
          textafter.x(-textafter.bbox().w / 2);
          break;
        case 'end':
          textafter.x(-textafter.bbox().w);
          break;
        default:
      }

      text.svg.add(textafter);
    }

    eraser.front();
    showActionDayHint();

    text.svg.size(parseInt($('#textsize').val(), 10));

    area.areaMargin = 30;
    area.areaUpper = draw.height() - text.svg.height() - area.areaMargin;
    text.svg.move(20, area.areaUpper);

    // green layer behind text
    area.greenBackground.remove();
    area.greenBackground = draw.rect(draw.width(), text.svg.height() + (2 * area.areaMargin))
      .y(area.areaUpper - area.areaMargin)
      .fill('#A0C864');
    text.svg.front();

    logo.svg.hide();

    if (area.logoDrawn) {
      area.logoResize();
    } else {
      area.logo = draw.image(logo.logoinfo.file, () => {
        area.logoResize();
        area.logoDrawn = true;
      });
    }
  },

  logoResize() {
    area.logo.size(area.greenBackground.height() * 0.5, area.greenBackground.height() * 0.5)
      .move(draw.width() - (1.5 * area.logo.width()),
        area.areaUpper - area.areaMargin - area.logo.height() * 0.6)
      .show()
      .front();
  },
};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext, #showclaim').bind('input propertychange', area.draw);
