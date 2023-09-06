/* eslint-disable no-undef */
const detext = {
    svg: draw.text(''),
    align: 'left',
    font: {
      family: 'GrueneType',
      anchor: 'left',
      size: 20,
    },
  
    draw() {
      const lines = $('#text').val().replace(/\n$/, '').split(/\n/);
  
      detext.svg.remove();
      detext.svg = draw.group().addClass('draggable').draggable();
  
      detext.svg.on('dragend.namespace', function detextDragEnd() {
        $('#textX').val(Math.round(this.x()));
        $('#textY').val(Math.round(this.y()));
      });
  
      lines.forEach((value, index) => {
        if( value === '' ) return;

        const line = draw.group();
        const indentation = value.match(/^\s*/)[0].length;
        const fondPadding = 4;

        const colors = {
            'tanne' : '#005437',
            'klee' : '#008939',
            'grashalm' : '#8abd24',
            'sand' : '#f5f1e9',
        }
  
        const colorNames = $('#line1').val().split('/')
        let textColor = colors[colorNames[0]];
        let fondColor = colors[colorNames[1]];
  
        const text = line.text(value.replace(/^\s*/, ''))
          .font(Object.assign(detext.font, { }))
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
          .skew(-9,0)
          .back();
  
        line.x(indentation * 5)
          .y(index * 28); // Zeilenhöhe
  
        detext.svg.add(line);
      });
  
      detext.svg
        .size($('#textsize').val())
        .move($('#textX').val(), $('#textY').val());
  
      detext.svg.front();
    },
  
  
  };
  
  $('.detext').bind('input propertychange',  detext.draw);
  
  $('.align-center-text').click(() => {
    $('#textX').val((draw.width() - detext.svg.width()) / 2);
    $('#textY').val((draw.height() - detext.svg.height()) / 2);
    detext.draw();
  });
  