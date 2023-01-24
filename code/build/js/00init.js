/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
/* eslint-disable no-else-return */
const draw = SVG().addTo('#canvas');

const info = { foo: null };
const log = { };

$(document).ready(() => {
  $('#width').val(bgpic.originalWidth);
  $('#height').val(bgpic.originalHeight);

  if ($(window).width() < 800) {
    const fraction = $(window).width() / 800;
    $('head meta[name="viewport"]').attr('content', `width=800, initial-scale=${fraction}`);
  }
  
  afterUpload(bgpic);

  $('[data-click]').click(function onClickData() {
    window[$(this).data('click')]();
  });

  $('input,textarea').change(() => { $('#qrcode').hide(); });

  config.useragent = navigator.userAgent;
  config.browser = getBrowser();
  config.useSaveWork = false;
  config.startEditTime = Date.now();

  log.user = config.username;
  log.tenant = config.tenant;
});

function message(text = false) {
  if (!text) {
    $('#message').hide();
    return;
  }
  $('#message').show().html(text);
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


$('.to-front').click(function tofront() {
  // eslint-disable-next-line no-eval
  const indirectEval = eval;
  let target = $(this).data('target');
  if (target === 'text' && config.layout !== 'lines') {
    target = config.layout;
  }

  if (target === 'logo') {
    indirectEval(target).svg.front();
  } else {
    indirectEval(target).draw();
  }

  eraser.draw();
});

function getBrowser() {
  if ((navigator.userAgent.indexOf('Opera') || navigator.userAgent.indexOf('OPR')) !== -1) {
    return 'Opera';
  } else if (navigator.userAgent.indexOf('Chrome') !== -1) {
    return 'Chrome';
  } else if (navigator.userAgent.indexOf('Safari') !== -1) {
    return 'Safari';
  } else if (navigator.userAgent.indexOf('Firefox') !== -1) {
    return 'Firefox';
  } else if ((navigator.userAgent.indexOf('MSIE') !== -1) || (!!document.documentMode === true)) {
    return 'IE';
  } else {
    return 'Unknown';
  }
}
