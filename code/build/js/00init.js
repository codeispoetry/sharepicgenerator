// eslint-disable-next-line no-unused-vars
const draw = SVG().addTo('#canvas');

// eslint-disable-next-line no-unused-vars
const info = { foo: null };

$(document).ready(() => {
  $('#width').val(bgpic.originalWidth);
  $('#height').val(bgpic.originalHeight);

  if ($(window).width() < 800) {
    const fraction = $(window).width() / 800;
    $('head meta[name="viewport"]').attr('content', `width=800, initial-scale=${fraction}`);
  }

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

// eslint-disable-next-line no-unused-vars
function getDownloadName() {
  let downloadname = $('#text').val().toLowerCase();
  downloadname = downloadname.replace(/[ä|ö|ü|ß]/g, (match) => {
    switch (match) {
      case 'ä':
        return 'ae';
      case 'ö':
        return 'oe';
      case 'ü':
        return 'ue';
      case 'ß':
        return 'ss';
      default:
        return '';
    }
  });
  downloadname = downloadname.replace(/[^a-zA-Z0-9]/g, '-');
  downloadname = downloadname.replace(/-+/g, '-');
  downloadname = downloadname.replace(/^-/g, '');
  downloadname = downloadname.replace(/-$/g, '');
  downloadname = downloadname.substring(0, 30);

  return downloadname;
}

// eslint-disable-next-line no-unused-vars
function getEncodingStatus(elem) {
  $.ajax({
    url: `/actions/getvideoencodestatus.php?videofile=${config.videofile}`,
    type: 'GET',
    dataType: 'JSON',
    success(data) {
      const percentage = Math.round((100 * data.currentposition) / config.videoduration);
      elem.html(`${percentage}% des Videos sind schon fertig. Bitte warten.`);
    },
  });
}

// eslint-disable-next-line no-unused-vars
function getTextInfo() {
  console.log(
    'Size, X, Y:',
    $('#textsize').val(),
    $('#textX').val(),
    $('#textY').val(),
  );
}

$('.to-front').click(function tofront() {
  const indirectEval = eval;
  let target = $(this).data('target');
  if (target === 'text' && config.layout !== 'lines') {
    target = config.layout;
  }

  if (target === 'logo') {
    indirectEval(target).load();
  } else {
    indirectEval(target).draw();
  }

  eraser.draw();
});
