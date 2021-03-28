const basic = {
  svg: draw.text(''),
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    leading: '1.0em',
    size: 20,
  },

  draw() {
    config.noBackgroundDragAndDrop = false;

    basic.svg.remove();

    basic.svg = draw.group().attr('id', 'svg-baisctext').addClass('draggable').draggable();

    basic.svg.on('dragend.namespace', function dragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
    });

    const size = parseInt($('#textsize').val(), 10);
    const family = $('#textfont').val();
    const anchor = $('#textanchor').val();

    const basicContent = draw.text($('#text').val())
      .font(Object.assign(basic.font, { family, size, anchor }))
      .fill($('#textcolor').val());

    basicContent.attr('xml:space', 'preserve');
    basicContent.attr('style', 'white-space:pre');

    basic.svg.add(basicContent);

    basic.svg.move(parseInt($('#textX').val(), 10), parseInt($('#textY').val(), 10));
  },

};

$('#text, #textsize, #textfont, #textanchor').bind('input propertychange', basic.draw);