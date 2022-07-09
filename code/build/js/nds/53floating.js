/* eslint-disable no-undef */
const floating = {
  svg: draw.text(''),
  fond: draw.circle(0),
  font: {
    family: 'BereitBold',
    leading: '1.05em',
    size: 20,
  },

  draw() {
    if (config.layout !== 'floating'
       || $('#text').val() === '') {
      return;
    }

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    const lines = $('#text').val().replace(/\n$/, '').split(/\n/);

    $('.linepickers').addClass('d-none');

    let y = 0;
    const sizeLineHeights = [];
    sizeLineHeights[10] = 10;
    sizeLineHeights[15] = 15;
    sizeLineHeights[20] = 20;
    sizeLineHeights[25] = 27;
    sizeLineHeights[30] = 33;

    lines.forEach((value, index) => {
      const line = draw.group();
      const indentation = value.match(/^\s*/)[0].length;
      const color = $(`#line${index}color`).val() || 'white';
      const size = $(`#line${index}size`).val() || '10';

      line.text(value.replace(/^\s*/, ''))
        .font(Object.assign(floating.font, { size }))
        .fill(color)
        .move(indentation * 5, y)
        .attr('xml:space', 'preserve')
        .attr('style', 'white-space:pre');

      floating.svg.add(line);

      y += sizeLineHeights[size];
      $(`.linepicker${index}`).removeClass('d-none');
    });

    const scaleFactor = parseInt($('#textsize').val(), 10) / 100;
    floating.svg
      .scale(scaleFactor, $('#textX').val(), $('#textY').val())
      .move($('#textX').val(), $('#textY').val());

    floating.svg.front();
  },

};

$('#text, #textsize').bind('input propertychange', floating.draw);
