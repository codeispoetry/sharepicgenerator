/* eslint-disable no-undef */
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

$(document).ready(() => {
  if (config.user.prefs.showGridlines) {
    $('#gridlines').prop('checked', true);
    $('.gridline').removeClass('d-none');
  } else {
    $('#gridlines').prop('checked', false);
    $('.gridline').addClass('d-none');
  }

  $('#gridlines').bind('change', () => {
    $('.gridline').toggleClass('d-none');
    config.user.prefs.showGridlines = !$('.gridline').hasClass('d-none');
    setUserPrefs();
  });
});

function highlightGridLine() {
  $('.gridline-active').removeClass('gridline-active');

  const centerX = this.x() + (this.width() / 2);
  const centerY = this.y() + (this.height() / 2);
  const snapDistance = 5;

  if (Math.abs((draw.width() * 0.5) - centerX) < snapDistance) {
    $('#grid-vertical-center').addClass('gridline-active');
  }
  if (Math.abs((draw.width() * 0.382) - centerX) < snapDistance) {
    $('#grid-vertical-left').addClass('gridline-active');
  }
  if (Math.abs((draw.width() * 0.618) - centerX) < snapDistance) {
    $('#grid-vertical-right').addClass('gridline-active');
  }

  if (Math.abs((draw.height() * 0.5) - centerY) < snapDistance) {
    $('#grid-horizontal-center').addClass('gridline-active');
  }
  if (Math.abs((draw.height() * 0.382) - centerY) < snapDistance) {
    $('#grid-horizontal-upper').addClass('gridline-active');
  }
  if (Math.abs((draw.height() * 0.618) - centerY) < snapDistance) {
    $('#grid-horizontal-lower').addClass('gridline-active');
  }
}
