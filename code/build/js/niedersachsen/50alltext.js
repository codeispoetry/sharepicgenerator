const textColors = ['white', 'black', '#46962b', '#E6007E', '#FEEE00'];

// eslint-disable-next-line no-unused-vars
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

// eslint-disable-next-line no-unused-vars
function showActionDayHint() {
  if (!/tag/i.test($('#text').val())) {
    $('#actiondayshint').hide();
    return false;
  }

  $('#actiondayshint').show();
  return true;
}


// eslint-disable-next-line no-unused-vars
function setLineHeight() {
  if (config.lineHeightToggledManually) {
    return;
  }

  if (/Ä|Ö|Ü|g|j|p|q|y/.test($('#text').val())) {
    nolines.font.leading = '1.17em';
  }else{
    nolines.font.leading = '1.05em';
  }
}

$('.toggle-line-height').click(() =>{
  config.lineHeightToggledManually = true;
  if (nolines.font.leading == '1.05em') {
    nolines.font.leading = '1.17em';
  } else {
    nolines.font.leading = '1.05em';
  }

  area.draw();
  nolines.draw();
});

const claim = {
  svg: draw.image('/assets/niedersachsen/claim.png', () => {
    claim.loaded = true;
    claim.svg.hide();
  }),
};

// eslint-disable-next-line no-unused-vars
function firstLineHasAscender(text) {
  return /Ä|Ö|Ü/.test(text.split('\n')[0]);
}

// eslint-disable-next-line no-unused-vars
function lastLineHasDescender(text) {
  return /g|j|p|q|y/.test(text.split('\n').reverse()[0]);
}

