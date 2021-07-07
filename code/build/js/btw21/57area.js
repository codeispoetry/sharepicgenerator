/* eslint-disable no-undef */
const area = {
  svg: draw.text(''),
  fond: draw.circle(0),
  fondPadding: 30,
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
    if (config.layout !== 'area'
       || $('#text').val() === '') {
      return;
    }

    if (typeof floating === 'object' && floating !== null) {
      floating.hide();
    }

    area.svg.remove();
    area.svg = draw.group();

    setLineHeight();

    const t = draw.text($('#text').val())
      .font(area.font)
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textafter').val()) {
      area.svg.add(area.drawTextAfter(t));
    }

    area.svg.add(t);

    if ($('#showclaim').prop('checked')) {
      area.drawClaim(t);
    }

    area.svg
      .size($('#textsize').val())
      .move(area.fondPadding, draw.height() - area.getLowerFondCorrection() - area.fondPadding);

    eraser.front();

    area.drawFond();
    area.svg.front();
    window.setTimeout(area.drawLogo, 500);
  },

  drawClaim(t) {
    return claim.svg
      .clone()
      .addTo(area.svg)
      .front()
      .show()
      .move(-3, 5 + area.svg.height());
  },

  drawTextAfter(t) {
    claim.svg.hide();
    return draw.text($('#textafter').val())
      .font(area.fontAfter)
      .fill('#FFFFFF')
      .move(0, 8 + t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');
  },

  getLowerFondCorrection() {
    let height = area.svg.height();

    if ($('#showclaim').prop('checked') === true) {
      return height;
    }

    text = $('#text').val();
    heihgtCorrection = 0.09;
    if ($('#textafter').val() && $('#showclaim').prop('checked') === false) {
      text = $('#textafter').val();
      heihgtCorrection = 0.03;
    }

    if (!lastLineHasDescender(text)) {
      height -= height * heihgtCorrection;
    }

    return height;
  },

  getUpperFondCorrection() {
    let height = area.svg.height();

    if (firstLineHasAscender($('#text').val())) {
      height = 0;
    } else {
      height *= 0.09;
    }

    return height;
  },

  drawFond() {
    area.fond.remove();
    const h = area.getLowerFondCorrection() - area.getUpperFondCorrection()
        + (2 * area.fondPadding);
    area.fond = draw.rect(draw.width(), h)
      .move(0, draw.height() - h)
      .fill('#a0c864');
  },

  drawLogo() {
    const size = area.fond.height() * 0.7;
    logo.svg
      .size(size, size)
      .move(draw.width() - (size * 1.2), draw.height() - area.fond.height() - (size * 0.7))
      .removeClass('draggable')
      .draggable(false)
      .front();
  },

  hide() {
    area.svg.hide();
    area.fond.hide();
  },

};

$('#text, #textafter, #textsize, #graybehindtext, #showclaim').bind('input propertychange', area.draw);
