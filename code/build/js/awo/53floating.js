/* eslint-disable no-undef */
const floating = {
  svg: draw.text(''),
  fond: draw.circle(0),
  fondPadding: 30,
  align: 'left',
  font: {
    family: 'Paralucent Condensed',
    anchor: 'left',
    leading: '1.05em',
    size: 20,
  },
  fontAfter: {
    family: 'Paralucent Condensed',
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
    const family = $('#textfont').val();

    const t = draw.text($('#text').val())
      .font(Object.assign(floating.font, { family }))
      .fill($('#textcolor').val())
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    if ($('#textShadow').prop('checked')) {
      t.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(0.5);
        add.blend(add.$source, blur);
      });
    }

    floating.svg.add(t);

    if ($('#textafter').val()) {
      floating.svg.add(floating.drawTextAfter(t));
    }

    const scaleFactor = parseInt($('#textsize').val(), 10) / 100;

    floating.svg
      .scale(scaleFactor, $('#textX').val(), $('#textY').val())
      .move($('#textX').val(), $('#textY').val());

    floating.svg.front();

    logo.setPosition();
    awoclaim.draw();
    copyright.draw();
  },

  drawTextAfter(t) {
    claim.svg.hide();
    const textafter = draw.group();

    const text = draw.text($('#textafter').val())
      .font(floating.fontAfter)
      .fill('#000000')
      .attr('xml:space', 'preserve')
      .attr('style', 'white-space:pre');

    const bg = draw.rect(text.bbox().w + 4, text.bbox().h + 0)
      .fill('#ffcd1c')
      .move(-2, -0)
      //.skew(-3, 0)
      .addTo(textafter);

    textafter.add(text);

    textafter.move(floating.svg.width() - textafter.bbox().w, 6 + t.bbox().height);

    return textafter;
  },

  hide() {
    floating.svg.hide();
  },

};

$('#text, #textafter, #textbefore, #textsize, #showclaim, #claimtext, #textfont, #textShadow, #textcolor').bind('input propertychange', floating.draw);
$('.text-align').click(floating.setAlign);

$('.align-center-text').click(() => {
  const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
  const textWidth = floating.svg.width() * scaleFactor;
  const textHeight = floating.svg.height() * scaleFactor;

  $('#textX').val((draw.width() - textWidth) / 2);
  $('#textY').val((draw.height() - textHeight) / 2);
  floating.draw();
});