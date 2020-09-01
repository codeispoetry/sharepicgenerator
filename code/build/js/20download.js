$('#download,.download').click(function onDownloadClick() {
  $(this).prop('disabled', true);

  config.toCloud = $(this).data('cloud');

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

  let format = 'jpg';

  if (config.video === true) {
    format = 'mp4';
    background.svg.hide();
  }

  const data = draw.svg();

  if (config.video === true) {
    background.svg.show();
  }

  $.ajax({
    type: 'POST',
    url: '/actions/createpic.php',
    data: {
      svg: data, format, addtogallery: $('#add-to-gallery').prop('checked'), tenant: config.tenant, user: config.user, csrf: config.csrf, quality: config.quality, usepixabay: config.usePixabay, ismosaic: config.isMosaic, socialmediaplatform: config.socialmediaplatform, videofile: config.videofile, width: $('#width').val(),
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
