$('#download,.download').click(function onDownloadClick() {
  $(this).prop('disabled', true);

  config.toCloud = $(this).data('cloud');

  const description = $(this).html();
  let secondsWaitingInterval;

  if (config.video) {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Das Video wird erstellt ...</span>');
    window.setTimeout(() => {
      secondsWaitingInterval = window.setInterval(() => {
        getEncodingStatus();
      }, 3000);
    }, 3000);
  } else {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Augenblick bitte');
  }

  $('#canvas').addClass('opacity');

  let format = 'jpg';

  if (config.video === 1) {
    format = 'mp4';
    background.svg.hide();
  }

  const data = draw.svg();

  if (config.video === 1) {
    background.svg.show();
  }

  $.ajax({
    type: 'POST',
    url: '/actions/createpic.php',
    data: {
      svg: data, format: format, addtogallery: $('#add-to-gallery').prop('checked'), user:config.user, csrf: config.csrf, quality: config.quality, usepixabay: config.usePixabay, ismosaic: config.isMosaic, socialmediaplatform: config.socialmediaplatform, videofile: config.videofile, width: $('#width').val(),
    },
    success(createPicData) {
      const obj = JSON.parse(createPicData);
      $('.download').prop('disabled', false);
      $('#canvas').removeClass('opacity');
      $('.download').html(description);
      window.clearInterval(secondsWaitingInterval);

      let downloadname = getDownloadName();

      if (config.socialmediaplatform) {
        downloadname = `${downloadname.substring(0, 14)}-${config.socialmediaplatform.toLowerCase()}`;
      }

      if (config.isMosaic) {
        format = 'zip';
      }

      if (config.toCloud) {
        $('.download').html('speichere Sharepic in der Cloud ... ');
        $.ajax({
          type: 'POST',
          url: '/actions/nextcloudsend.php',
          data: {
            file: `${obj.basename}.jpg`,
            csrf: config.csrf,
          },
          success() {
            $('.download').html('speichere Arbeitsdatei in der Cloud ... ');
            // const obj = JSON.parse(data);

            $.ajax({
              type: 'POST',
              url: '/actions/savework.php',
              data: { csrf: config.csrf, data: $('#pic').serialize() },
              success(saveWorkData) {
                const saveWorkObj = JSON.parse(saveWorkData);
                $.ajax({
                  type: 'POST',
                  url: '/actions/nextcloudsend.php',
                  data: {
                    file: `${saveWorkObj.basename}.zip`,
                    csrf: config.csrf,
                    downloadname: `${downloadname}.zip`,
                  },
                  success() {
                    $('.download').html(description);
                  },
                });
              },
            });
          },
        });

        // const data = $('#pic').serialize();
      } else {
        window.location.href = `/actions/download.php?file=${obj.basename}&format=${format}&downloadname=${downloadname}`;
      }
    },
  });
});

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

function getEncodingStatus() {
  $.ajax({
    url: `/actions/getvideoencodestatus.php?videofile=${config.videofile}`,
    type: 'GET',
    dataType: 'JSON',
    success(data) {
      const percentage = Math.round((100 * data.currentposition) / config.videoduration);
      $('#download').html(`${percentage}% des Videos sind schon fertig. Bitte warten.`);
    },
  });
}
