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
    if (config.layout !== 'floating'
       || $('#text').val() === '') {
      return;
    }

    area.hide();

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    floating.svg.on('dragmove.namespace', highlightGridLine);

    setLineHeight();
    const anchor = floating.align;

    const t = draw.text($('#text').val().toUpperCase())
      .font(Object.assign(floating.font, { anchor }))
      .fill('#FFFFFF')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textbefore').val()) {
      floating.svg.add(floating.drawTextBefore());
    }

    if ($('#showclaim').prop('checked')) {
      floating.drawClaim();
    }

    if ($('#textafter').val()) {
      floating.svg.add(floating.drawTextAfter(t));
    }

    floating.svg.add(t);

    floating.svg
      .size($('#textsize').val())
      .move($('#textX').val(), $('#textY').val());

    if ($('#floatingshadow').prop('checked')) {
      floating.svg.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(2);
        add.blend(add.$source, blur);
      });
    }

    eraser.front();

    floating.svg.front();
  },

  drawClaim() {
    let x;
    switch (floating.align) {
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
      .addTo(floating.svg)
      .front()
      .show()
      .size(90)
      .move(x, 15 + floating.svg.height() + floating.svg.y());
  },

  drawTextBefore() {
    const textbefore = draw.text($('#textbefore').val())
      .font(floating.fontBefore)
      .fill('#FFE100')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    textbefore.move(0, -textbefore.bbox().h);

    switch (floating.align) {
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
    const distanceIconsText = 5;

    let y = 3;
    if ($('#showclaim').prop('checked')) {
      y = 22;
    }

    const icons = draw.text(`${brands.instagram} ${brands.twitter}/`)
      .font(fontBrands)
      .fill('#FFFFFF')
      .move(0, y + t.bbox().height);
    floating.svg.add(icons);

    const textafter = draw.text($('#textafter').val().toUpperCase())
      .font(floating.fontAfter)
      .fill('#FFFFFF')
      .move(icons.bbox().width + distanceIconsText, y + t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    switch (floating.align) {
      case 'middle':
        textafter.x(-textafter.bbox().w / 2);
        break;
      case 'end':
        textafter.x(-textafter.bbox().w);
        icons.x(-textafter.bbox().w - icons.bbox().w - distanceIconsText);
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

$('#text, #textafter, #textbefore, #textsize, #showclaim, #floatingshadow').bind('input propertychange',  floating.draw);
$('.text-align').click(floating.setAlign);

$('.align-center-text').click(() => {
  $('#textX').val((draw.width() - floating.svg.width()) / 2);
  $('#textY').val((draw.height() - floating.svg.height()) / 2);
  floating.draw();
});
