/* eslint-disable no-undef */
const berlintext = {
  svg: draw.text(''),
  align: 'left',
  font: {
    family: 'BereitBold',
    anchor: 'left',
    size: 20,
  },
  fontAfter: {
    family: 'BereitBold',
    anchor: 'left',
    size: 17,
  },

  draw() {
    if ($('#text').val() === '') {
      return;
    }

    const lines = $('#text').val().replace(/\n$/, '').split(/\n/);

    berlintext.svg.remove();
    berlintext.svg = draw.group().addClass('draggable').draggable();

    berlintext.svg.on('dragend.namespace', function berlintextDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    if ($('#textafter').val()) {
      const mainTextHeight =  lines.length * 28;
      berlintext.svg.add(berlintext.drawTextAfter().dy(mainTextHeight));
    }

    berlintext.svg.attr('id', 'berlintext');

    lines.forEach((value, index) => {
      const line = draw.group();
      const indentation = value.match(/^\s*/)[0].length;
      const fondPadding = 4;

      const fondColor = $('#textcolor1').val();
      const textColor = (fondColor == '#006a52') ? '#FFFFFF' : '#006a52';

      const text = line.text(value.replace(/^\s*/, ''))
        .font(Object.assign(berlintext.font, { }))
        .fill(textColor)
        .move(0, 0)
        .attr('xml:space', 'preserve')
        .attr('style', 'white-space:pre');

      const fond = line.rect(
        text.bbox().width + (2 * fondPadding), text.bbox().height + (2 * fondPadding)
      )
        .fill(fondColor)
        .x(-fondPadding)
        .y(-fondPadding)
        .back();

      line.x(indentation * 5)
        .y(index * 28); // Zeilenhöhe

      berlintext.svg.add(line);
    });

    berlintext.svg
      .size($('#textsize').val())
      .move($('#textX').val(), $('#textY').val());

    if ($('#berlintext-shadow').prop('checked')) {
      berlintext.svg.filterWith((add) => {
        const blur = add.offset(0, 0).in(add.$sourceAlpha).gaussianBlur(5);
        add.blend(add.$source, blur);
      });
    }

    

    berlintext.svg.front();
    berlintext.svg.skew(0, -4);
  },

  drawTextAfter() {
    const textafter = draw.group();

    const lines = $('#textafter').val().replace(/\n$/, '').split(/\n/);

    const fondColor = $('#textcolor2').val();
    const textColor = (fondColor == '#006a52') ? '#FFFFFF' : '#006a52';

    lines.forEach((value, index) => {
      const line = draw.group();
      const indentation = value.match(/^\s*/)[0].length;
      const fondPadding = 2;

      const text = line.text(value.replace(/^\s*/, ''))
        .font(Object.assign(berlintext.fontAfter, { }))
        .fill(textColor)
        .move(0, 0)
        .attr('xml:space', 'preserve')
        .attr('style', 'white-space:pre');

      const fond = line.rect(
        text.bbox().width + (2 * fondPadding), text.bbox().height + (2 * fondPadding)
      )
        .fill(fondColor)
        .x(-fondPadding)
        .y(-fondPadding)
        .back();

      line.x(indentation * 5)
        .y(index * 22);

      textafter.add(line);
    });

    textafter.dy(0)

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
