/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};

var initialized = false;

$(document).ready(() => {

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  if (config.user.prefs.claimtext) {
    $('#claimtext').val(config.user.prefs.claimtext);
    $('#claimcolor').val(config.user.prefs.claimcolor);
  }

  $('#textX').val(20);
  $('#textY').val(draw.height() / 2);

  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });
});

function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  initialized = true;

  background.drawColor();
  logo.draw();
  floating.draw();
  pin.draw();

  return true;
}

function reset() {
  // do nothing, stay here
}

