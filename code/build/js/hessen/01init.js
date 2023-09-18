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
  $('#textscaled').val(3);
  $('#logoX').val(465);
  $('#logoY').val(35);

  //open();

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
  hessenlogo.draw('/assets/hessen/logo.svg');
  banderole.draw();
  floating.draw();
  pin.draw();
  background.svg.hide();

  //uploadFileByUrl('http://localhost/assets/vorlage.jpg');

  return true;
}

function reset() {
  // do nothing, stay here
  hessenlogo.resize();
  hessenlogo.setPosition();
  banderole.draw();
}

