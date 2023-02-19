/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bg_small.jpg',
  fullBackgroundName: '../assets/bg.jpg',
};

$(document).ready(() => {
  $('#textX').val(20);
  $('#textY').val(draw.height() / 2);
  $('#logoX').val(20);
  $('#logoY').val(20 );
  $('#textsize').val(270);
});

function initSharepic() {
  if (initialized) {
    return false;
  }
  // called after background pic is loaded
  $('#sizepresets').val('1200:1200').trigger('change');
  initialized = true;

  background.drawColor();
  defaultlogo.draw();
  floating.draw();
  pin.draw();
  upperrect.draw();

  return true;
}

function reset() {
  upperrect.draw();
}

