$('#copyright').bind('input propertychange', () => {
  copyright.draw();
});

// eslint-disable-next-line no-unused-vars
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

    let y;

    switch ($('#copyrightPosition').val()) {
      case 'upperLeft':
        y = copyright.svg.length() + 12;
        break;
      default:
        y = draw.height() - 12;
    }

    copyright.svg.move(10, y)
      .rotate(-90, copyright.svg.x(), copyright.svg.y());
  },
};
