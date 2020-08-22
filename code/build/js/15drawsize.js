$('.size').bind('input propertychange', setDrawsize);
$('#sizereset').click(resetDrawsize);

$('#sizepresets').on('change', function changeSize() {
  const dimensions = this.value.split(':');
  setDimensions(...dimensions);

  config.socialmediaplatform = $('#sizepresets option:selected').data('socialmediaplatform');
  config.quality = $('#sizepresets option:selected').data('quality');

  config.isMosaic = (config.socialmediaplatform.search(/Mosaik/g) !== -1);

  deleteMosaicLines();
  if (config.isMosaic) {
    showMosaicLines();
  }

  background.resize();
});

$('.size').bind('input propertychange', () => {
  // unselect presets, if user changes sizes manually
  $('#sizepresets').val($('#sizepresets option:first').val());
});

function setDrawsize() {
  let width = $('#width').val();
  let height = $('#height').val();
  const aspectratio = width / height;

  config.socialmediaplatform = '';

  if (width > 800) {
    width = 800;
    height = width / aspectratio;
  }

  while (height > 800) {
    width -= 50;
    height = width / aspectratio;
  }

  draw.size(width, height);

  $('#canvas').width(draw.width());
  $('#canvas').height(draw.height());

  calculateSizes();

  text.bounce();
  pin.bounce();

  window.setTimeout(logo.draw, 100);
  window.setTimeout(copyright.draw, 200);
  window.setTimeout(copyright.draw, 300);// has to be here twice. Don't know, why.
}

function resetDrawsize() {
  $('#width').val(info.originalWidth);
  $('#height').val(info.originalHeight);
  // unselect presets, if user changes sizes manually
  $('#sizepresets').val($('#sizepresets option:first').val());
  setDrawsize();
}

function setDimensions(width, height) {
  $('#width').val(width);
  $('#height').val(height);
  setDrawsize();
}

function calculateSizes() {
  // here are also the default sizes after init
  $('#textsize').attr('min', draw.width() * 0.1);
  $('#textsize').attr('max', draw.width());
  $('#textsize').val(draw.width() * 0.3);

  $('#textX').val(0);
  $('#textY').val(draw.height() / 5);

  $('#pinX').val(draw.width() * 0.7);
  $('#pinY').val(draw.height() * 0.5);

  $('#backgroundsize').attr('min', draw.width());
  $('#backgroundsize').attr('max', draw.width() * 5);
  $('#backgroundsize').val(draw.width());

  $('#backgroundX').val(0);
  $('#backgroundY').val(0);

  reset();
}

$('.choose-mosaic').bind('click', () => {
  $('#sizepresets').val('2400:2400').trigger('change');
});
