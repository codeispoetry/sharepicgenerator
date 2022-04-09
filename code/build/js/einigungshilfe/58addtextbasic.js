const addtextbasic = {
  svg: draw.text(''),
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },

  draw() {
    config.noBackgroundDragAndDrop = false;

    addtextbasic.svg.remove();

    addtextbasic.svg = draw.group().attr('id', 'svg-addtextbasic').addClass('draggable').draggable();

    addtextbasic.svg.on('dragend.namespace', function dragEnd() {
      $('#addtextbasicX').val(Math.round(this.x()));
      $('#addtextbasicY').val(Math.round(this.y()));
    });

    const size = parseInt($('#addtextbasicsize').val(), 10);
    const family = $('#addtextbasicfont').val();

    const addtextContent = draw.text($('#addtextbasic').val())
      .font(Object.assign(addtextbasic.font, { family, size }))
      .fill($('#addtextbasicColor').val());

    addtextContent.attr('xml:space', 'preserve');
    addtextContent.attr('style', 'white-space:pre');

    addtextbasic.svg.add(addtextContent);

    addtextbasic.svg.move(parseInt($('#addtextbasicX').val(), 10), parseInt($('#addtextbasicY').val(), 10));
  },

};

$('#addtextbasic, #addtextbasicsize, #addtextbasicColor, #addtextbasicfont').bind('input propertychange', addtextbasic.draw);
