/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};

let initialized = false;

$(document).ready(() => {
  $('#textsize').val(202);
  $('#textX').val(91);
  $('#textY').val(172);

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  if (config.user.prefs.claimtext) {
    $('#claimtext').val(config.user.prefs.claimtext);
    $('#claimcolor').val(config.user.prefs.claimcolor);
  }

  $('#addtextX').val(50);
  $('#addtextY').val(draw.height() - 50);

  showLayout();

  defaultlogo.svg.remove();

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
  reDraw();
  return true;
}

function reset() {
  // do nothing, stay here
  area.draw();
}

function reDraw(withAddPic = false) {
  if (withAddPic === true) {
    addPic1.draw();
    addPic2.draw();
    addPic3.draw();
    addPic4.draw();
    addPic5.draw();
  }

  window.setTimeout(() => {
    pin.draw();
    pin.drawTemplate();
  }, 10);

  window.setTimeout(() => {
    copyright.draw();
  }, 20);

  window.setTimeout(() => {
    addtext.draw();
    floating.draw();
    
    $('.align-center-text').trigger('click');
  }, 100);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}
