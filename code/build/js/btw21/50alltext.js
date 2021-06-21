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
});
