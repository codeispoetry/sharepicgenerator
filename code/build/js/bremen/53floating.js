/* eslint-disable no-undef */
var inFloatingDraw = 0;
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
    size: 20,
  },
  fontCiteSymbol: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 80,
  },
  fontAfter: {
    family: 'BereitBold',
    anchor: 'left',
    leading: '1.05em',
    size: 10,
  },

  draw() {
    if ($('#text').val() === '') {
      return;
    }

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    const anchor = floating.align;

    const t = draw.text($('#text').val().toUpperCase())
      .font(Object.assign(floating.font, { anchor }))
      .fill($('#textcolor').val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      t.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

    if ($('#textafter').val()) {
      floating.svg.add(floating.drawTextAfter(t));
    }

    floating.svg.add(t);

    floating.drawClaim(t);

    if ($('#textbefore').val() || $('#layout-cite').prop('checked')) {
      floating.svg.add(floating.drawTextBefore());
    }

    floating.svg
      .move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10 ))
      .size(parseInt($('#textsize').val(), 10));
   
    if (!$('#advancedmode').prop('checked')) {
      const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
      defaultlogo.setSize(17 * scaleFactor * 1.7);
      pin.setSize(17 * scaleFactor * 1.7 * 1.15);
    }
    
    floating.svg.front();
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
    switch (floating.align) {
      case 'middle':
        x = -claim.width() / 2;
        break;
      case 'end':
        x = -claim.width();
        break;
      default:
        x = 0;
    }

    claim.move(x, 8 + floating.svg.height() + 1 - 20);

    claim.addTo(floating.svg);
  },

  drawTextBefore() {
    let content = $('#textbefore').val().toUpperCase();
    let color = $('#textbeforecolor').val() || '#FFFFFF';
    let font = floating.fontBefore;

    if ($('#layout-cite').prop('checked')) {
      content = ',,';
      color = '#FFFFFF';
      font = floating.fontCiteSymbol;
    }

    const textbefore = draw.text(content)
      .font(font)
      .fill(color)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      textbefore.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

    textbefore.move(0, -20 - textbefore.bbox().h);

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
   // claim.svg.hide();

    const textafter = draw.text($('#textafter').val())
      .font(floating.fontAfter)
      .fill($('#textaftercolor').val() || '#FFFFFF')
      .move(0, -20 + t.bbox().height)
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      textafter.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

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

$('#text, #textafter, #textbefore, #textsize, #showclaim, #claimtext, #textShadow, .change-text').bind('input propertychange', floating.draw);
$('.text-align').click(floating.setAlign);

$('.align-center-text').click(() => {
  const textWidth   = floating.svg.width();
  const textHeight  = floating.svg.height();
  $('#textX').val((draw.width() - textWidth) / 2);
  $('#textY').val((draw.height() - textHeight) / 2);
  floating.draw();
});
