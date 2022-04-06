/* eslint-disable no-undef */
// eslint-disable-next-line no-unused-vars
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
  $('#textsize').val(502);
  $('#textX').val(41);
  $('#textY').val(372);

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  $('#addtextX').val(50);
  $('#addtextY').val(draw.height() - 50);

  showLayout();

  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });
});

// eslint-disable-next-line no-unused-vars
function initSharepic() {
  if (initialized) {
    bgpattern.svg.remove();
    return false;
  }

  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  $('#textX').val(150);
  $('#textY').val(70);
  floating.draw();
  bgpattern.draw();

  initialized = true;
  return true;
}

// eslint-disable-next-line no-unused-vars
function reset() {
  // do nothing, stay here
  floating.draw();
}

// eslint-disable-next-line no-unused-vars
function reDraw(withAddPic = false) {
  if (withAddPic === true) {
    addPic1.draw();
    addPic2.draw();
    addPic3.draw();
    addPic4.draw();
    addPic5.draw();
  }

  window.setTimeout(() => {
    copyright.draw();
    logo.reposition('leftcenter');
    $('#logoposition').val('leftcenter');
    if (config.filename === undefined) {
      bgpattern.draw();
    }
  }, 20);

  window.setTimeout(() => {
    addtextSH.draw();
    eraser.draw();
  }, 100);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}
