const addtext = {
  svg: draw.text(''),
  colors: ['white', 'black', '#46962b', '#E6007E', '#FEEE00'],
  colorIndex: 0,
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    family: 'PT Sans',
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },

  draw() {
    config.noBackgroundDragAndDrop = false;

    if ($('#addtext').val() === '') return;
    console.log(addtext.svg.remove());

    addtext.svg = draw.group().attr('id', 'svg-addtext').addClass('draggable').draggable();

    addtext.svg.on('dragend.namespace', function dragEnd() {
      $('#addtextX').val(Math.round(this.x()));
      $('#addtextY').val(Math.round(this.y()));
    });

    const fontSize = parseInt($('#addtextsize').val(), 10);
    const addtextContent = draw.text($('#addtext').val())
      .font(Object.assign(addtext.font, { size: fontSize }))
      .fill(addtext.colors[addtext.colorIndex]);
    addtext.svg.add(addtextContent);

    eraser.front();
    showActionDayHint();

    addtext.svg.move(parseInt($('#addtextX').val(), 10), parseInt($('#addtextY').val(), 10));
  },

};

$('.addtext-change-color').click(() => {
  addtext.colorIndex += 1;
  addtext.colorIndex %= addtext.colors.length;
  addtext.draw();
});

$('#addtext, #addtextsize').bind('input propertychange', addtext.draw);
