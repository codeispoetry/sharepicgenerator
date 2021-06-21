// eslint-disable-next-line no-unused-vars
function setLineHeight() {
  if (config.lineHeightToggledManually) {
    return;
  }

  if (/Ä|Ö|Ü|g|j|p|q|y/.test($('#text').val())) {
    area.font.leading = '1.17em';
  }else{
    area.font.leading = '1.05em';
  }
}

// eslint-disable-next-line no-unused-vars
function firstLineHasAscender(text) {
  return /Ä|Ö|Ü/.test(text.split('\n')[0]);
}

// eslint-disable-next-line no-unused-vars
function lastLineHasDescender(text) {
  return /g|j|p|q|y/.test(text.split('\n').reverse()[0]);
}

$('.toggle-line-height').click(() =>{
  config.lineHeightToggledManually = true;
  if (area.font.leading == '1.05em') {
    area.font.leading = '1.17em';
  } else {
    area.font.leading = '1.05em';
  }

  area.draw();
});

const claim = {
  svg: draw.image('/assets/btw21/claim.svg', () => {
    claim.loaded = true;
    claim.svg.hide();
  }),
};

$('#textafter').bind('input propertychange', () => {
  $('#showclaim').prop('checked', false);
});
