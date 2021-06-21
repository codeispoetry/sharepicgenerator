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

    if ($('#text').val() === '') return;

    const anchor = nolines.align;

    const t = draw.text($('#text').val())
      .font(
        Object.assign(nolines.font, { anchor }),
      )
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    // text or claim below the line
    if ($('#showclaim').prop('checked')) {
      const w = claimWidth;
      const h = 7;
      const claimFond = draw.polyline(`0,0 ${w},0 ${w},${h}, 0,${h}`).fill('#ffe100').skew([-9, 0]);
      const claimTextLine = draw.text(claimText)
        .fill('#145f32')
        .font(area.fontoutsidelines)
        .move(1, 0);
      const claim = draw.group();
      claim.add(claimFond);
      claim.add(claimTextLine);

      switch (area.align) {
        case 'middle':
          claim.x(-claim.width() / 2);
          break;
        case 'end':
          claim.x(-claim.width());
          break;
        default:
      }
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
      switch (nolines.align) {
        case 'middle':
          textafter.x(-textafter.bbox().w / 2);
          break;
        case 'end':
          textafter.x(-textafter.bbox().w);
          break;
        default:
      }
    }

    eraser.front();

    area.areaMargin = 30;
    area.areaUpper = 20;

    copyright.svg.front();

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
