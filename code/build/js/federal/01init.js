// eslint-disable-next-line no-unused-vars
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};

$(document).ready(() => {
  $('#textsize').val(502);
  $('#textX').val(41);
  $('#textY').val(372);
  config.layout = 'nolines';

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  $('#logosize').val(17);
  logo.resize($('#logosize').val());

  $('.toast').toast({ delay: 10000 });
  $('.toast-actionday').toast('show');

  $('#addtextX').val(50);
  $('#addtextY').val(draw.height() - 50);

  showLayout();
});

// eslint-disable-next-line no-unused-vars
function initSharepic() {
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  $('#textY').val(320);
  $('#textsize').val(402);
}

// eslint-disable-next-line no-unused-vars
function reset() {
  // do nothing, stay here
}

// eslint-disable-next-line no-unused-vars
function reDraw(withAddPic = false) {
  if (withAddPic === true) {
    addPic1.draw();
    addPic2.draw();
  }

  window.setTimeout(() => {
    pin.draw();
  }, 10);

  window.setTimeout(() => {
    copyright.draw();
    icon.load();
  }, 20);

  window.setTimeout(() => {
    logo.load();
    text.draw();
    addtext.draw();
    quote.draw();
    nolines.draw();
    invers.draw();
    eraser.draw();
  }, 100);
}
