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
 
  $('#textX').val(20);
  $('#textY').val(draw.height() / 2);
  $('#textsize').val(270);
  $('#logosize').val(30);
  $('#logoX').val(30);
  $('#logoY').val(450);

  open();

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

  $('#advancedmode').click();

  background.drawColor();
  defaultlogo.draw();
  floating.draw();
  pin.draw();

  return true;
}

function reset() {
  // do nothing, stay here
}

