$('#gridlines').bind('change', () => {
  $('.gridline').toggleClass('d-none');
});

// eslint-disable-next-line no-unused-vars
function showMosaicLines() {
  for (let i = 1; i <= 2; i++) {
    $('#canvas').append(`<div class="gridline horizontal mosaicline" style="top:${(100 * i) / 3}%;"></div>`);
    $('#canvas').append(`<div class="gridline vertical mosaicline" style="top:0;left:${(100 * i) / 3}%;"></div>`);
  }
}

// eslint-disable-next-line no-unused-vars
function deleteMosaicLines() {
  $('.mosaicline').remove();
}
