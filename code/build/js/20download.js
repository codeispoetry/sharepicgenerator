/* eslint-disable no-undef */
$('#download,.download').click(function onDownloadClick() {
  $(this).prop('disabled', true);

  const description = $(this).html();
  let secondsWaitingInterval;

  $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
  
  $('#canvas').addClass('opacity');

  let { format } = config;

  log.socialmedia = config.socialmediaplatform;

  const data = draw.svg();

  log.uploadTime = config.uploadTime;
  log.editTime = Math.round((Date.now() - config.startEditTime) / 1000);

  $.ajax({
    type: 'POST',
    url: '/actions/createpic.php',
    data: {
      svg: data,
      format,
      width: $('#width').val(),
      sharepic: $('#pic').serialize(),
      config: JSON.stringify(config),
      log: JSON.stringify(log),
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

      window.location.href = `/actions/download.php?file=${obj.basename}&format=${format}&downloadname=${downloadname}`;
    },
  });
});
