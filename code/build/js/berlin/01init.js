/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/berlin/bg_small.jpg',
  fullBackgroundName: '../assets/berlin/bg.jpg',
};

var initialized = false;

$(document).ready(() => {
  $('#textsize').val(502);
  $('#textX').val(61);
  $('#textY').val(172);
  $('#logoX').val(382);
  $('#logoY').val(142);

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

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
  $('#textY').val(120);
  initialized = true;

 // background.drawColor();
  logo.draw();
  claimBerlin.draw();
  return true;
}

function reset() {
  // do nothing, stay here
  berlintext.draw();
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
    //frame.draw();
  }, 20);

  window.setTimeout(() => {
    addtext.draw();
    logo.draw();
    claimBerlin.draw();
  }, 100);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}
