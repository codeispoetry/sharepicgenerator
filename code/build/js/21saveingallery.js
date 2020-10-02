$('.saveInGallery').click(function onSaveInGalleryClick() {
  $(this).prop('disabled', true);

  const description = $(this).html();
  let secondsWaitingInterval;

  if (config.video) {
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Das Video wird erstellt ...</span>');
    window.setTimeout(() => {
      secondsWaitingInterval = window.setInterval(() => {
        getEncodingStatus($(this));
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
      svg: data, format, addtogallery: true, tenant: config.tenant, user: config.user, csrf: config.csrf, quality: config.quality, usepixabay: config.usePixabay, ismosaic: config.isMosaic, socialmediaplatform: config.socialmediaplatform, videofile: config.videofile, width: $('#width').val(),
    },
    success(createPicData) {
      const obj = JSON.parse(createPicData);
      window.clearInterval(secondsWaitingInterval);

      if (config.isMosaic) {
        format = 'zip';
      }

      $('.saveInGallery').html('Speichere Arbeitsdatei');
      $.ajax({
        type: 'POST',
        url: '/actions/savework.php',
        data: {
          csrf: config.csrf, saveingallery: true, filename: obj.basename, tenant: config.tenant, data: $('#pic').serialize(),
        },
        success() {
          $('.saveInGallery').prop('disabled', false);
          $('#canvas').removeClass('opacity');
          $('.saveInGallery').html(description);
          $('#gallery-note').html('Gespeichert.')
            .fadeIn()
            .delay(5000)
            .fadeOut('slow');

          let a = parseInt($('#allGalleryImages').html(), 10) + 1;
          $('#allGalleryImages').html(a);
          a = parseInt($('#ownGalleryImages').html(), 10) + 1;
          $('#ownGalleryImages').html(a);
        },
      });
    },
  });
});
