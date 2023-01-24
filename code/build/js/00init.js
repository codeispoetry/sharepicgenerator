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

  $('input,textarea').change(() => { $('#qrcode').hide(); });

  config.useragent = navigator.userAgent;
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

$('.to-front').click(function tofront() {
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
});

function hide(className) {
  $(`.${className}`).addClass('d-none');
}

function show(className) {
  $(`.${className}`).removeClass('d-none');
}
