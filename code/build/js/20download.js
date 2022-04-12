/* eslint-disable no-undef */
$('#download,.download').click(function onDownloadClick() {
  $(this).prop('disabled', true);

  const description = $(this).html();
  let secondsWaitingInterval;

  if (config.video) {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Das Video wird erstellt ...</span>');
    secondsWaitingInterval = window.setInterval(() => {
      getEncodingStatus($('#download'));
    }, 3000);
  } else {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
  }

  $('#canvas').addClass('opacity');

  let { format } = config;

  log.socialmedia = config.socialmediaplatform;

  if (config.video === true) {
    format = 'mp4';
    background.svg.hide();
    background.colorlayer.hide();
  }

  const data = draw.svg();

  if (config.video === true) {
    background.svg.show();
  }

  log.uploadTime = config.uploadTime;
  log.editTime = Date.now() - config.startEditTime;

  $.ajax({
    type: 'POST',
    url: '/actions/createpic.php',
    data: {
      svg: data,
      format,
      width: $('#width').val(),
      quality: config.quality,
      sharepic: $('#pic').serialize(),
      config: JSON.stringify(config),
      log: JSON.stringify(log),
      videofile: config.videofile,
    },
    success(createPicData) {
      const obj = JSON.parse(createPicData);
      $('.download').prop('disabled', false);
      $('#canvas').removeClass('opacity');
      $('.download').html(description);
      window.clearInterval(secondsWaitingInterval);

      let downloadname = getDownloadName();

      config.uploadTime = -1;

      if (config.socialmediaplatform) {
        downloadname = `${downloadname.substring(0, 14)}-${config.socialmediaplatform.toLowerCase()}`;
      }

      const qrcode = `/tmp/qrcode_${obj.basename}.png`;
      $('#qrcode').show();
      window.setTimeout(
        () => { $('#qrcode-img').html(`<img src="${qrcode}">`); },
        500,
      ); // timeout needed for firefox. Otherwise img "could not be loaded"
      $('#qrcode-createtime').html(config.createTime / 1000);

      window.location.href = `/actions/download.php?file=${obj.basename}&format=${format}&downloadname=${downloadname}`;
    },
  });
});
