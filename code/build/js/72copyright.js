$('#copyright').bind('input propertychange', () => {
  copyright.draw();
});

function setCopyright(message, carrier) {
  if (message === undefined) {
    return false;
  }

  const attribution = `Foto: ${message} / ${carrier}`;

  show('show-copyright');
  $('#copyright').val(attribution);
  copyright.draw();
  return true;
}

const copyrightfont = {
  family: 'Arial',
  size: 9,
  anchor: 'left',
  weight: 300,
};

const copyright = {
  svg: draw.text(''),

  draw() {
    copyright.svg.remove();

    copyright.svg = draw.text($('#copyright').val())
      .font(copyrightfont)
      .fill($('#copyrightcolor').val());

    let x = 10;
    let y = draw.height() - 12;
    let rotation = -90;

    switch ($('#copyrightPosition').val()) {
      case 'upperLeft':
        x = 10;
        y = copyright.svg.length() + 12;
        rotation = -90;
        break;
      case 'bottomRight':
        x = draw.width() - 20;
        y = draw.height() - 12;
        rotation = -90;
        break;
      case 'bottomLeftHorizontal':
        x = 6;
        y = draw.height() - 12;
        rotation = 0;
        break;
      case 'bottomRightHorizontal':
        x = draw.width() - copyright.svg.length() - 6;
        y = draw.height() - 12;
        rotation = 0;
        break;
      default:
        x = 10;
        y = draw.height() - 12;
        rotation = -90;
    }

    copyright.svg.move(x, y)
      .rotate(rotation, copyright.svg.x(), copyright.svg.y());
  },

  front() {
    copyright.svg.front();
  },
};
