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
  $('#textscaled').val(2);
  $('#logoX').val(-35);
  $('#logoY').val(360);
  $('#claimX').val(365);
  $('#claimY').val(435);
  open();

  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });


  if(config.user.prefs.hasSeenBlog == undefined) {
    $('#canvas-area').slideUp();
    $('#blog').show();
    config.user.prefs.hasSeenBlog = 1;
    setUserPrefs();
  }
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
  claim.draw();

  $('#advancedmode').click();

  return true;
}

function reset() {
  // do nothing, stay here
}

