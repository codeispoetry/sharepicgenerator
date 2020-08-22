// eslint-disable-next-line no-unused-vars
const draw = SVG().addTo('#canvas');

// eslint-disable-next-line no-unused-vars
const info = { foo: null };

// eslint-disable-next-line no-unused-vars
const secondaryfont = {
  family: 'ArvoGruen',
  size: 15,
  anchor: 'left',
  weight: 700,
};

$(document).ready(() => {
  $('#width').val(bgpic.originalWidth);
  $('#height').val(bgpic.originalHeight);

  pin.draw();
  window.setTimeout(text.draw, 10);
  afterUpload(bgpic);

  $('[data-click]').click(function onClickData() {
    window[$(this).data('click')]();
  });
});

// eslint-disable-next-line no-unused-vars
function message(text = false) {
  if (!text) {
    $('#message').hide();
    return;
  }
  $('#message').show().html(text);
}

// eslint-disable-next-line no-unused-vars
function redrawCockpit() {
  if (config.video) {
    $('.novideo').addClass('d-none');
  } else {
    $('.novideo').removeClass('d-none');
  }
}

// eslint-disable-next-line no-unused-vars
function hide(className) {
  $(`.${className}`).addClass('d-none');
}

// eslint-disable-next-line no-unused-vars
function show(className) {
  $(`.${className}`).removeClass('d-none');
}

// eslint-disable-next-line no-unused-vars
function basename(path) {
  const name = path.split('/').reverse()[0];
  return name.split('.')[0];
}

// eslint-disable-next-line no-unused-vars
function debug() {
  $('.debug').show();
}
