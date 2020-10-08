const invers = {
  svg: draw.text(''),
  backgroundClone: draw.circle(0),
  lineheight: 20,
  linemargin: -4,
  paddingLr: 5,
  font: {
    family: 'ArvoGruen',
    anchor: 'left',
    leading: '1.0em',
    size: 20,
  },

  draw() {
    if (config.layout !== 'invers') {
      return false;
    }

    config.noBackgroundDradAndDrop = true;

    invers.svg.remove();
    invers.backgroundClone.remove();
    text.svg.remove();

    invers.svg = draw.group().addClass('draggable').draggable();

    invers.svg.on('dragstart.namespace', () => {
      inversRect.opacity(0.5);
    });

    invers.svg.on('dragend.namespace', function dragEnd() {
      $('#textX').val(Math.round(this.x()));
      $('#textY').val(Math.round(this.y()));
      config.layout = 'nolines';
      nolines.draw();
      config.layout = 'invers';
      invers.draw();
    });

    const inversText = $('#text').val().replace(/\[|\]/g, '').toUpperCase();
    const inversTextSvg = draw.text(inversText).font(Object.assign(invers.font));

    invers.svg.add(inversTextSvg)
      .move(text.svg.x(), text.svg.y())
      .size(parseInt($('#textsize').val(), 10));

    invers.backgroundClone = background.svg.clone();
    draw.add(invers.backgroundClone);

    invers.backgroundClone.clipWith(inversTextSvg);

    const inversRect = draw.rect(inversTextSvg.bbox().width, inversTextSvg.bbox().height)
      .fill('white')
      .size(parseInt($('#textsize').val(), 10) + 20)
      .move(inversTextSvg.bbox().x - 10, inversTextSvg.bbox().y - 4);

    invers.backgroundClone.front();

    invers.svg.add(inversRect);

    return true;
  },

};

$('#text, #textafter, #textbefore, #textsize').bind('input propertychange', invers.draw);
