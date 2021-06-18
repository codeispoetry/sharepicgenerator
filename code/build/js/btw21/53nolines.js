/* eslint-disable no-undef */
const nolines = {
  svg: draw.text(''),
  grayBackground: draw.circle(0),
  colors: ['#ffffff', '#ffffff'],
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  align: 'left',
  font: {
    anchor: 'left',
    family: 'BereitBold',
    leading: '1.05em',
    size: 20,
  },
  fontoutsidelines: {
    family: 'BereitBold',
    size: 6,
    anchor: 'left',
    leading: '1.0em',
  },

  draw() {
    if (config.layout !== 'nolines') {
      return;
    }

    if ($(this).attr('id') === 'textafter') {
      $('#showclaim').prop('checked', false);
    }

    config.noBackgroundDragAndDrop = false;

    text.svg.remove();
    area.svg.remove();
    if (area.logo) {
      area.logo.hide();
    }
    area.greenBackground.remove();
    invers.svg.remove();
    invers.backgroundClone.remove();
    if ($('#text').val() === '') return;

    text.svg = draw.group().attr('id', 'svg-text');

    textDragging();

    const anchor = nolines.align;

    const t = draw.text($('#text').val())
      .font(
        Object.assign(nolines.font, { anchor }),
      )
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    text.svg.add(t);

    // text below the line

    if ($('#showclaim').prop('checked')) {
      const w = 50;
      const h = 9;
      const claimFond = draw.polyline(`0,0 ${w},0 ${w},${h}, 0,${h}`).fill('#ffe100').skew([-9, 0]);
      const claimText = draw.text('Bereit, weil Ihr es seid.')
        .fill('#145f32')
        .font(nolines.fontoutsidelines)
        .move(1, 1);
      const claim = draw.group();
      claim.add(claimFond);
      claim.add(claimText);
      claim.y(text.svg.height());

      switch (nolines.align) {
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

    // gray layer behind text
    text.grayBackground.remove();
    if ($('#graybehindtext').prop('checked')) {
      const grayGradient = draw.gradient('radial', (add) => {
        add.stop({ offset: 0, color: $('#colorbehindtext').val(), opacity: 0.9 });
        add.stop({ offset: 0.9, color: $('#colorbehindtext').val(), opacity: 0.0 });
      });
      grayGradient.from(0.5, 0.5).to(0.5, 0.5).radius(0.5);

      text.grayBackground = draw.rect(text.svg.width(), text.svg.height())
        .fill({ color: grayGradient, opacity: 0.3 })
        .back();
    }

    text.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10)).size(parseInt($('#textsize').val(), 10));
    text.positionGrayBackground();
    logo.svg.show();
  },

  setAlign() {
    nolines.align = $(this).data('align');
    nolines.draw();
  },

};

$('#text, #textafter, #textbefore, #textsize, #graybehindtext, #showclaim').bind('input propertychange', nolines.draw);
$('.text-align').click(nolines.setAlign);
