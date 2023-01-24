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
  fontBefore: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 10,
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
    logo.svg.draggable(false);

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

    area.drawClaim(t);

    if ($('#textbefore').val()) {
      area.svg.add(area.drawTextBefore());
    }

    area.svg
      .size($('#textsize').val())
      .move(
        area.fondPadding,
        draw.height() - area.getLowerFondCorrection() - ((1 + area.getFactorDistanceToBottom()) * area.fondPadding)
      );

    

    area.drawFond();
    area.svg.front();
    copyright.front();
    pin.front();
    window.setTimeout(area.drawLogo, 500);
  },

  drawClaim(t) {
    if ($('#claimtext').val() === '') {
      return;
    }

    const claim = draw.group();

    let textColor = '#FFFFFF';
    if ($('#claimcolor').val() === '#ffe100') {
      textColor = '#145f32';
    }

    const textInClaim = $('#claimtext').val();

    const claimText = draw.text(textInClaim)
      .font({
        family: 'BereitBold',
        anchor: 'left',
        leading: '1.05em',
        size: 8,
      })
      .move(2, 1)
      .fill(textColor);

    // if (textInClaim.includes('Ä') || textInClaim.includes('Ö') || textInClaim.includes('Ü')) {

    const claimBackground = draw.rect(claimText.bbox().w + 4, 11.5)
      .fill($('#claimcolor').val())
      .skew(-8, 0)
      .addTo(claim);

    claimText.addTo(claim);

    let x;
    switch (area.align) {
      case 'middle':
        x = -claim.width() / 2;
        break;
      case 'end':
        x = -claim.width();
        break;
      default:
        x = 0;
    }

    claim.move(x, 8 + area.svg.height() + 1);

    claim.addTo(area.svg);
  },

  drawTextBefore() {
    const textbefore = draw.text($('#textbefore').val())
      .font(area.fontBefore)
      .fill('#FFE100')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    textbefore.move(0, -textbefore.bbox().h);

    switch (area.align) {
      case 'middle':
        textbefore.x(-textbefore.bbox().w / 2);
        break;
      case 'end':
        textbefore.x(-textbefore.bbox().w);
        break;
      default:
    }

    return textbefore;
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

    if ($('#claimtext').val() !== '') {
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
        + ((2 + area.getFactorDistanceToBottom()) * area.fondPadding);
    area.fond = draw.rect(draw.width(), h)
      .move(0, draw.height() - h)
      .fill('#a0c864');
  },

  getFactorDistanceToBottom() {
    if (config.socialmediaplatform === 'Instagram-Bild-4x5') {
      return 1;
    }

    return 0;
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

$('#text, #textafter, #textbefore, #textsize, #graybehindtext, #showclaim').bind('input propertychange', area.draw);
