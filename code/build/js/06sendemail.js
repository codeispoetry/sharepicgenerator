/* eslint-disable no-undef */
$('#send_email').bind('click', () => {
  if (!$('#recipient').is(':valid')) {
    // eslint-disable-next-line prefer-template
    alert($('#recipient').val() + ' ist keine richtige E-Mail-Adresse.');
    return;
  }

  config.user.prefs.recipient = $('#recipient').val();
  setUserPrefs();

  $('#send_email').prop('disabled', true);
  const label = $('#send_email').val();
  $('#send_email').val('Augenblick...');
  $('#canvas').addClass('opacity');
  $('#download').prop('disabled', true);

  const data = draw.svg();
  const { format } = config;

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
    },
    success(createPicData) {
      const obj = JSON.parse(createPicData);

      $.ajax({
        type: 'POST',
        url: '/actions/mail.php',
        data: {
          recipient: $('#recipient').val(),
          file: `${obj.basename}.${format}`,
          text: $('#text').val(),
        },
        success(response) {
          const obj = JSON.parse(response);
          $('#send_email').prop('disabled', false);
          $('#send_email').val(label);

          if (obj.success === 'true') {
            // eslint-disable-next-line prefer-template
            alert('Die E-Mail mit dem Sharepic wurde an ' + $('#recipient').val() + ' versendet.');
          } else {
            console.log(obj);
            alert('Es ist ein Fehler aufgetreten. Die E-Mail konnte nicht versendet werden.');
          }
          $('#canvas').removeClass('opacity');
          $('#download').prop('disabled', false);
        },
      });
    },
  });
});

$(document).ready(() => {
  if (config.user.prefs.recipient) {
    $('#recipient').val(config.user.prefs.recipient);
  }
});
