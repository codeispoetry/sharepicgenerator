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
 
  $('#textX').val(200);
  $('#textY').val(200);
  $('#textsize').val(205);
  $('#logoX').val(-125);
  $('#logoY').val(135);
  $('#logosize').val(50);
  $('#text').val("Die Zukunft\nänderst Du\nhier!");
  $('#lineSize0').val(200);
  $('#lineSize1').val(300);
  $('#lineSize2').val(200);

  $('#lineColorSet0').val("sand/tanne");
  $('#lineColorSet1').val("tanne/sand");
  $('#lineColorSet2').val("sand/tanne");

  $('#textsize').val(340);

  // $('#pintext').val("SSS\nMMM\nLLL");
  // $('#pinLineSize0 option:eq(0)').prop("selected",true);
  // $('#pinLineSize1 option:eq(1)').prop("selected",true);
  // $('#pinLineSize2 option:eq(2)').prop("selected",true);

  $('#eyecatchersize').val(200);

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

