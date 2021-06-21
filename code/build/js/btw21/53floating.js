/* eslint-disable no-undef */
const floating = {
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
    if (config.layout !== 'floating'
       || $('#text').val() === '') {
      return;
    }

    area.hide();

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragend.namespace', function dragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    setLineHeight();
    const anchor = floating.align;

    const t = draw.text($('#text').val())
      .font(Object.assign(floating.font, { anchor }))
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    // text or claim below the line
    if ($('#showclaim').prop('checked')) {
      floating.drawClaim(t);
    } else if ($('#textafter').val()) {
      floating.svg.add(floating.drawTextAfter(t));
    }

    floating.svg.add(t);

    floating.svg
      .size($('#textsize').val())
      .move($('#textX').val(), $('#textY').val());

    logo.draw();

    eraser.front();

    floating.svg.front();
  },

  drawClaim(t) {
    let x;
    switch (floating.align) {
      case 'middle':
        x = -40;
        break;
      case 'end':
        x = -80;
        break;
      default:
        x = -3;
    }

    return claim.svg
      .clone()
      .addTo(floating.svg)
      .front()
      .show()
      .size(80)
      .move(x, 5 + t.bbox().height);
  },

  drawTextAfter(t) {
    claim.svg.hide();

    const textafter = draw.text($('#textafter').val())
      .font(floating.fontAfter)
      .fill('#FFFFFF')
      .move(0, t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch (floating.align) {
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
    floating.svg.hide();
  },

  setAlign() {
    floating.align = $(this).data('align');
    floating.draw();
  },
};

$('#text, #textafter, #textsize, #graybehindtext, #showclaim').bind('input propertychange',  floating.draw);
$('.text-align').click(floating.setAlign);
