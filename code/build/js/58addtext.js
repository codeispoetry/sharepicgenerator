const addtext = {
  svg: draw.text(''),
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    family: $('#addtextFont').val(),
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },

  draw() {
    config.noBackgroundDragAndDrop = false;

    addtext.svg.remove();

    addtext.svg = draw.group().attr('id', 'svg-addtext').addClass('draggable').draggable();

    addtext.svg.on('dragend.namespace', function dragEnd() {
      $('#addtextX').val(Math.round(this.x()));
      $('#addtextY').val(Math.round(this.y()));
    });

    const fontSize = parseInt($('#addtextsize').val(), 10);
    const addtextContent = draw.text($('#addtext').val())
      .font(Object.assign(addtext.font, { size: fontSize }))
      .fill($('#addtextColor').val());

    addtextContent.attr('xml:space', 'preserve');
    addtextContent.attr('style', 'white-space:pre');

    addtext.svg.add(addtextContent);

    

    addtext.svg.move(parseInt($('#addtextX').val(), 10), parseInt($('#addtextY').val(), 10));
  },

};

$('#addtext, #addtextsize').bind('input propertychange', addtext.draw);

$('#addtext, #addtextsize').on('change', () => {
  undo.save();
});

$('.align-center-addtext').click(() => {
  $('#addtextX').val((draw.width() - addtext.svg.width()) / 2);
  $('#addtextY').val((draw.height() - addtext.svg.height()) / 2);
  addtext.draw();
  undo.save();
});