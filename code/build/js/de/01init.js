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
 
  $('#textX').val(10);
  $('#textY').val(20);
  $('#textsize').val(205);
  $('#logoX').val(-125);
  $('#logoY').val(135);
  $('#logosize').val(50);
  $('#text').val("MMM\nMMM\nMMM");
  $('#lineSize0 option:eq(0)').prop("selected",true);
  $('#lineSize1 option:eq(1)').prop("selected",true);
  $('#lineSize2 option:eq(2)').prop("selected",true);
  $('#textsize').val(540);

  $('#pintext').val("Mittwoch\n3.10\nMarkplatz");
  $('#pinLineSize1 option:eq(1)').prop("selected",true);


  $('.close-target').click(function doCloseTarget() {
    $($(this).data('target')).slideUp();
  });

  $('optgroup[Label=Flyeralarm]').hide();

  window.setTimeout(
    () => { detext.draw();},
    500,
  );
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
  detext.draw();
  pin.draw();

  $('#advancedmode').click();

  return true;
}

function reset() {
  // do nothing, stay here
}

