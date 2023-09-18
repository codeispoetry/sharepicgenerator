/* eslint-disable no-undef */
const bgpic = {
  width: 800,
  height: 450,
  originalWidth: 1920,
  originalHeight: 1080,
  filename: '/assets/bayern/bg_small.jpg',
  fullBackgroundName: '../assets/bayern/bg.jpg',
};

var initialized = false;

$(document).ready(() => {
 
  $('#textX').val(50);
  $('#textY').val(65);
  $('#text2X').val(94);
  $('#text2Y').val(210);
  $('#textscaled').val(2.6);
  $('#logoX').val(230);
  $('#logoY').val(200);


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

  //background.drawColor();
  bayernlogo.draw();
  floating.draw();
  pin.draw();
  frame.draw();
  subfloating.draw();
  return true;
}

function reset() {
  frame.draw();
  bayernlogo.draw();
}
