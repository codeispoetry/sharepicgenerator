/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small_basic.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};
// Generator http://andresgalante.com/RGBAtoFeColorMatrix/
var greenifyMatrix = [
  0.33, 0, 0, 0, 0,
  0, 0.53, 0, 0, 0,
  0, 0, 0.78, 0, 0,
  0, 0, 0, 1, 0,
];


var initialized = false;

$(document).ready(() => {
  $('#textsize').val(99);
  $('#textX').val(20);
  $('#textY').val(372);

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const clickId = urlParams.get('clickId');
  $(`#${clickId}`).click();

  $('#logosize').val(17);
  logo.resize($('#logosize').val());

  showLayout();

  $('.expertmode').toggleClass('d-none');

});

function disableFeature(feature) {
  $(feature).attr('data-target', '').addClass('disabled').on('click', () => {
    alert('Um diese Funktion nutzen zu können, melden Sie sich bitte an');
  });
}

function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  $('#textY').val(320);
  $('#textsize').val(99);
  initialized = true;

  return true;
}

function reset() {
  // do nothing, stay here
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
  }, 10);

  window.setTimeout(() => {
    copyright.draw();
    icon.load();
  }, 20);

  window.setTimeout(() => {
    logo.load();
    text.draw();
    addtextbasic.draw();
    quote.draw();
    nolines.draw();
    invers.draw();
    
    upperrect.draw();
  }, 100);

  if ($('#backgroundFlipped').val() === 'true') {
    $('#backgroundflip').click();
  }
}
