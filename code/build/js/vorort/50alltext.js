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

function firstLineHasAscender(text) {
  return /Ä|Ö|Ü/.test(text.split('\n')[0]);
}

function lastLineHasDescender(text) {
  return /g|j|p|q|y/.test(text.split('\n').reverse()[0]);
}

$('.toggle-line-height').click(() =>{
  config.lineHeightToggledManually = true;

  if (config.layout === 'area') {
    area.font.leading = (area.font.leading === '1.05em') ? '1.17em' : '1.05em';
    area.draw();
  }

  if (config.layout === 'floating') {
    floating.font.leading = (floating.font.leading === '1.05em') ? '1.17em' : '1.05em';
    floating.draw();
  }
});

const claim = {
  svg: draw.image('/assets/btw21/claim.svg', () => {
    claim.loaded = true;
    claim.svg.size(90, 13.5).hide();
  }),
};
