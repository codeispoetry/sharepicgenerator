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
  $('#textsize').val(202);
  $('#textX').val(41);
  $('#textY').val(372);

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  showLayout();

  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });
});

// eslint-disable-next-line no-unused-vars
function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  initialized = true;

  background.drawColor();

  return true;
}

// eslint-disable-next-line no-unused-vars
function reset() {
  // do nothing, stay here
  area.draw();
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
    pin.draw();
    pin.drawTemplate();
  }, 10);

  window.setTimeout(() => {
    addtext.draw();
    floating.draw();
  }, 100);

}
