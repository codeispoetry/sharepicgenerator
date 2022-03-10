const addtextSH = {
  svg: draw.text(''),
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    family: 'AzoSansLight',
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },

  draw() {
    config.noBackgroundDragAndDrop = false;

    addtextSH.svg.remove();

    addtextSH.svg = draw.group().attr('id', 'svg-addtext').addClass('draggable').draggable();

    addtextSH.svg.on('dragend.namespace', function dragEnd() {
      $('#addtextX').val(Math.round(this.x()));
      $('#addtextY').val(Math.round(this.y()));
    });

    const fontSize = parseInt($('#addtextsizeSH').val(), 10);
    const addtextContent = draw.text($('#addtextSH').val())
      .font(Object.assign(addtextSH.font, { size: fontSize }))
      .fill('white');

    addtextContent.attr('xml:space', 'preserve');
    addtextContent.attr('style', 'white-space:pre');

    addtextSH.svg.add(addtextContent);

    addtextSH.svg.move(parseInt($('#addtextX').val(), 10), parseInt($('#addtextY').val(), 10));
  },

};

$('#addtextSH, #addtextsizeSH').bind('input propertychange', addtextSH.draw);
