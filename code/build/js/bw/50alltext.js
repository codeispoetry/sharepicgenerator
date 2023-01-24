const textColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];

function textChangeColor() {
  let textColorIndex = parseInt($('#textColor').val(), 10);
  textColorIndex += 1;
  textColorIndex %= textColors.length;

  $('#textColor').val(textColorIndex);

  text.draw();
  quote.draw();
}

function alignCenter() {
  const x = (draw.width() - text.svg.width()) / 2;
  const y = (draw.height() - text.svg.height()) / 2;

  text.svg.move(x, y);

  $('#textX').val(Math.round(x));
  $('#textY').val(Math.round(y));
  text.bounce();
  text.positionGrayBackground();
}
$('.aligncenter').click(alignCenter);

