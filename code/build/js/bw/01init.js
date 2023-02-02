const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_bw_small.jpg',
  fullBackgroundName: '../assets/bg_bw.jpg',
};

var initialized = false;

$(document).ready(() => {
  $('#textsize').val(300);
  $('#textX').val(151);
  $('#textY').val(262);
  config.layout = 'nolines';

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  //showLayout();
});

function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');

  initialized = true;
  reDraw();
  return true;
}

function reset() {
  // do nothing, stay here
}

function reDraw(withAddPic = false) {
  if (withAddPic === true) {
    addPic1.draw();
    addPic2.draw();
  }

  window.setTimeout(() => {
    pin.draw();
  }, 10);

  window.setTimeout(() => {
    logo.load();
    text.draw();
    addtext.draw();
    quote.draw();
    nolines.draw();
    invers.draw();
    
  }, 100);

  window.setTimeout(() => {
    text.draw();
  }, 700);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}
