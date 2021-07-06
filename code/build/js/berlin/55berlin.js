/* eslint-disable no-undef */
const berlintext = {
  svg: draw.text(''),
  fond: draw.circle(0),
  fondPadding: 30,
  align: 'left',
  font: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 20,
  },
  fontAfter: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 10,
  },

  draw() {
    if (config.layout !== 'berlintext'
       || $('#text').val() === '') {
      return;
    }

    berlintext.svg.remove();
    berlintext.svg = draw.group().addClass('draggable').draggable();

    berlintext.svg.on('dragend.namespace', function berlintextDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    setLineHeight();
    const anchor = berlintext.align;

    const t = draw.text($('#text').val())
      .font(Object.assign(berlintext.font, { anchor }))
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textafter').val()) {
      berlintext.svg.add(berlintext.drawTextAfter(t));
    }

    berlintext.svg.add(t);

    if ($('#showclaim').prop('checked')) {
      berlintext.drawClaim(t);
    }

    berlintext.svg
      .size($('#textsize').val())
      .move($('#textX').val(), $('#textY').val());

    if ($('#berlintext-shadow').prop('checked')) {
      berlintext.svg.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(5);
        add.blend(add.$source, blur);
      });
    }

    eraser.front();

    berlintext.svg.front();
  },

  drawClaim(t) {
    let x;
    switch (berlintext.align) {
      case 'middle':
        x = -45;
        break;
      case 'end':
        x = -90;
        break;
      default:
        x = -3;
    }

    return claim.svg
      .clone()
      .addTo(berlintext.svg)
      .front()
      .show()
      .size(90)
      .move(x, 5 + berlintext.svg.height());
  },

  drawTextAfter(t) {
    claim.svg.hide();

    const textafter = draw.text($('#textafter').val())
      .font(berlintext.fontAfter)
      .fill('#FFFFFF')
      .move(0, 8 + t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch (berlintext.align) {
      case 'middle':
        textafter.x(-textafter.bbox().w / 2);
        break;
      case 'end':
        textafter.x(-textafter.bbox().w);
        break;
      default:
    }

    return textafter;
  },

  hide() {
    berlintext.svg.hide();
  },

  setAlign() {
    berlintext.align = $(this).data('align');
    berlintext.draw();
  },
};

$('#text, #textafter, #textsize, #showclaim, #berlintext-shadow').bind('input propertychange',  berlintext.draw);
$('.text-align').click(berlintext.setAlign);

$('.align-center-text').click(() => {
  $('#textX').val((draw.width() - berlintext.svg.width()) / 2);
  $('#textY').val((draw.height() - berlintext.svg.height()) / 2);
  berlintext.draw();
});
