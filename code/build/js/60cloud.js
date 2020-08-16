function getCloudfiles() {
  $.ajax({
    type: 'POST',
    url: '/actions/nextcloudget.php',
    data: {
      user: config.user,
      accesstoken: config.accesstoken,
    },
    success(data, textStatus, jqXHR) {
      const obj = JSON.parse(data);

      if (obj.status == '500') {
        $('#cloudmessage').show();
        $('#cloudmessage p').html('Kein Zugang zur Cloud.');
        $('#cloudnotoken').show();
        return;
      }

      const count = obj.data.length;
      let sharepics = '';
      switch (count) {
        case 0:
          sharepics = 'Keine Sharepics';
          break;
        case 1:
          sharepics = 'Ein Sharepic';
          break;
        default:
          sharepics = `${count} Sharepics`;
      }

      $('#cloudfiles option:first').html(`${sharepics} in der Cloud:`);
      $('#cloudfiles').prop('disabled', false);

      obj.data.forEach((element) => {
        $('#cloudfiles').append(new Option(basename(element), element));
      });

      $('#cloudhastoken').show();
      $('#cloudmessage').hide();
    },
  });
}

if (config.hasCloudCredentials) {
  $('#cloudmessage').show();
  getCloudfiles();
} else {
  $('#cloudmessage').hide();
  $('#cloudnotoken').show();
}

$('#cloudfiles').on('change', function () {
  if ($(this).val() == '') {
    return false;
  }

  $('#cloudmessage').show();
  $('#cloudmessage p').html('Das Bild wird geladen...');
  $.ajax({
    type: 'POST',
    url: '/actions/nextcloudget.php',
    data: {
      mode: 'file',
      file: $(this).val(),
      user: config.user,
      accesstoken: config.accesstoken,
    },
    success(data, textStatus, jqXHR) {
      $('#cloudmessage').hide();

      const obj = JSON.parse(data);
      const json = JSON.parse(obj.data);

      if (json.addpicfile1 != '') json.addpicfile1 = `../${obj.dir}/${json.addpicfile1}`;
      if (json.addpicfile2 != '')json.addpicfile2 = `../${obj.dir}/${json.addpicfile2}`;
      uploadFileByUrl(`${obj.dir}/${json.savedBackground}`, () => {
        loadFormData(json);
      });
    },
  });
});

$('#cloudtokensave').click(() => {
  const token = $('#cloudtoken').val();

  $('#cloudmessage').show();
  $('#cloudmessage p').html('Speichere Token ...');
  $('#cloudnotoken').hide();

  $.post('/actions/save.php', {
    user: config.user, action: 'saveCloudToken', data: token, accesstoken: config.accesstoken,
  })
    .done((data) => {
      $('#load').removeClass('d-none');
      $('#delete').removeClass('d-none');
      $('.saving-response').html('Gespeichert.').delay(2000).fadeOut();

      $('#cloudmessage').hide();

      $('#cloudhastoken').show();
    });
});

$('.cloudtokendelete').click(() => {
  if (!confirm('Wirklich die Verbindung zur Cloud löschen?')) {
    return false;
  }

  $.post('/actions/save.php', { user: config.user, action: 'deleteCloudToken', accesstoken: config.accesstoken })
    .done((data) => {
      $('#load').removeClass('d-none');
      $('#delete').removeClass('d-none');
      $('.saving-response').html('Gespeichert.').delay(2000).fadeOut();
    });

  $('#cloudnotoken').hide();
  $('#cloudhastoken').show();
});
