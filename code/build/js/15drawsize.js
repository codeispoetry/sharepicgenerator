$('.size').bind('input propertychange', setDrawsize);

$('#sizepresets').on('change', function changeSize() {
  const dimensions = this.value.split(':');
  setDimensions(...dimensions);

  config.socialmediaplatform = $('#sizepresets option:selected').data('socialmediaplatform');

  $('#grid-square').toggleClass('d-none', (config.socialmediaplatform !== 'Instagram-Bild-4x5'));

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

  while (height > 600) {
    width -= 50;
    height = width / aspectratio;
  }

  draw.size(width, height);

  $('#canvas').width(draw.width());
  $('#canvas').height(draw.height());

  calculateSizes();
  
  // check if ad is initialized
  if (typeof ad != 'undefined') {
    ad.setPosition();
  }

  //background.drawColor();
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
  $('#textsize').attr('min', draw.width() * 0.03);
  $('#textsize').attr('max', draw.width());

  $('#backgroundsize').attr('min', draw.width() * 0.5);
  $('#backgroundsize').attr('max', draw.width() * 5);
  
  reset();
}

