const copyrights = { };
let copyrightColorIndex = 0;
let copyrightColors = ['white', 'black'];
if (textColors !== undefined) {
  copyrightColors = textColors;
}

$('#copyright').bind('input propertychange', () => {
  copyright.draw();
});

$('.copyright-change-color').click(() => {
  copyrightColorIndex += 1;
  copyrightColorIndex %= copyrightColors.length;
  copyright.draw();
});

// eslint-disable-next-line no-unused-vars
function setCopyright(message, mode) {
  if (message === undefined) {
    return false;
  }

  if (mode === 'pixabay') {
    copyrights[mode] = `Foto: ${message}@pixabay.com`;
  } else {
    copyrights[mode] = `Icon: ${message}`;
  }

  show('show-copyright');
  $('#copyright').val(Object.values(copyrights).join(', '));
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
      .fill(copyrightColors[copyrightColorIndex]);

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
