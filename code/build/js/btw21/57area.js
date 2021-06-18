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
    leading: '1.05em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'BereitBold',
    size: 6,
    anchor: 'left',
    leading: '1.05em',
  },
  logoDrawn: false,

  draw() {
    if (config.layout !== 'area') {
      return;
    }

    setLineHeight();

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    const anchor = nolines.align;

    const t = draw.text($('#text').val())
      .font(
        Object.assign(nolines.font, { anchor }),
      )
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    text.svg.add(t);

    // text or claim below the line
    if ($('#showclaim').prop('checked')) { 
      const w = claimWidth;
      const h = 7;
      const claimFond = draw.polyline(`0,0 ${w},0 ${w},${h}, 0,${h}`).fill('#ffe100').skew([-9, 0]);
      const claimTextLine = draw.text('Bereit, weil Ihr es seid.')
        .fill('#145f32')
        .font(area.fontoutsidelines)
        .move(1, 0);
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
    text.svg.move(1.1 * area.areaMargin, area.areaUpper);

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
