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

    const withBackground = $('#floating-background').prop('checked');

    floating.svg.remove();
    floating.svg = draw.group().addClass('draggable').draggable();

    floating.svg.on('dragend.namespace', function floatingDragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    const lines = $('#text').val().replace(/\n$/, '').split(/\n/);

    $('.linepickers').addClass('d-none');

    const background = draw.rect(0, 0)
      .fill('#00594E');

    floating.svg.add(background).back();

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

    if (withBackground) {
      background.move(-5, -5).size(floating.svg.width() + 10, floating.svg.height() + 30);
      logo.svg.hide();

      const floatingLogo = draw.image('/assets/logos/sonnenblume-nds.svg', () => {
        floatingLogo.size(40, null)
          .move(
            floating.svg.width() - floatingLogo.width() - 10,
            floating.svg.height() - floatingLogo.height() - 10,
          );

        floating.svg.add(floatingLogo);
        floating.resize();
      });
    } else {
      floating.resize();
      logo.svg.show();
    }

    floating.svg.front();
  },

  resize() {
    floating.svg
      .move($('#textX').val(), $('#textY').val())
      .size(parseInt($('#textsize').val(), 10), null);
  },

};

$('#text, #floating-background').bind('input propertychange', floating.draw);
$('#textsize').bind('input propertychange', floating.resize);
