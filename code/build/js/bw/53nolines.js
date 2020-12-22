const textPrimaryColors = ['#ffffff', '#000000', '#009571', '#46962b', '#E6007E', '#FEEE00'];
const textSecondaryColors = ['#FEEE00', '#009571', '#46962b', '#E6007E'];

/* eslint-disable no-undef */
const nolines = {
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
    family: 'ArvoGruen',
    size: 8,
    anchor: 'middle',
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

    let lines = $('#text').val();
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

          color = textSecondaryColors[$('#textSecondaryColor').val()];
          if (style === 0) {
            color = textPrimaryColors[$('#textPrimaryColor').val()];
          }

          add.tspan(values[i]).fill(color).font(
            Object.assign(nolines.font, { family: fontfamily, anchor: $('#textanchor').val() }),
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
      lines = $('#textafter').val().replace(/\n$/, '').split(/\n/);
      lines.forEach((value, index) => {
        const textafterParts = value.split(/\[|\]/);
        let style = 1;
        const textafter = draw.text((add) => {
          for (let i = 0; i < textafterParts.length; i++) {
            style = (style === 0) ? 1 : 0;
            color = textSecondaryColors[$('#textSecondaryColor').val()];
            if (style === 0) {
              color = textPrimaryColors[$('#textPrimaryColor').val()];
            }

            add.tspan(textafterParts[i]).fill(color).font(
              Object.assign(nolines.fontoutsidelines, { anchor: $('#textanchor').val() }),
            );
            add.attr('xml:space', 'preserve');
            add.attr('style', 'white-space:pre');
          }
        });
        textafter.dy(text.svg.height() + 6);

        text.svg.add(textafter);
      });
    }

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

$('.textanchor').click(function setTextanchor() {
  $('#textanchor').val($(this).data('payload'));
  nolines.draw();
});

$('.text-change-primarycolor').bind('click', textChangePrimarycolor);
// eslint-disable-next-line no-unused-vars
function textChangePrimarycolor() {
  let textPrimaryColorIndex = parseInt($('#textPrimaryColor').val(), 10);
  console.log(textPrimaryColorIndex);
  textPrimaryColorIndex += 1;
  textPrimaryColorIndex %= textPrimaryColors.length;

  $('#textPrimaryColor').val(textPrimaryColorIndex);
  nolines.draw();
}

$('.text-change-secondarycolor').bind('click', textChangeSecondarycolor);
// eslint-disable-next-line no-unused-vars
function textChangeSecondarycolor() {
  let textSecondaryColorIndex = parseInt($('#textSecondaryColor').val(), 10);

  textSecondaryColorIndex += 1;
  textSecondaryColorIndex %= textSecondaryColors.length;

  $('#textSecondaryColor').val(textSecondaryColorIndex);
  nolines.draw();
}
