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
 
  $('#textX1').val(20);  $('#textY1').val(20);
  $('#textX2').val(20);  $('#textY2').val(60);
  $('#textX3').val(20);  $('#textY3').val(100);

  $('#textsize').val(270);

  $('#text2').trigger('propertychange');
  $('#text3').trigger('propertychange');

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
  defaultlogo.draw();
  floating.draw();
  pin.draw();

  return true;
}

function reset() {
  // do nothing, stay here
}

