$('.upload-file').change(function changeFile() {
  const id = $(this).attr('id');
  const file = document.getElementById(id).files[0];
  const size = document.getElementById(id).files[0].size / 1024 / 1024;
  const maxFileSize = 100; // in MB, note this in .htaccess as well
  const isBackgroundUpload = ($(this).attr('id') === 'uploadfile');
  if (size > maxFileSize) {
    alert(`Die Datei ist zu groß. Es sind maximal ${maxFileSize} MB erlaubt.\n\nSchicke Dir die Datei per z.B. WhatsApp zu, dann wird sie automatisch verkleinert. Mehr als 20 MB pro Minute Video braucht es nicht.`);
    return false;
  }

  $('#waiting').addClass('active');
  $(this).prop('disabled', true);

  const formData = new FormData();
  const client = new XMLHttpRequest();

  if (!file) {
    return false;
  }

  formData.append('file', file);
  formData.append('id', id);
  formData.append('csrf', config.csrf);

  client.onerror = function onError(e) {
    console.log('onError', e);
  };

  client.onload = function onLoad(e) {
    const obj = JSON.parse(e.target.response);
    $(`#${id}`).prop('disabled', false);
    $('#waiting').removeClass('active');

    if (obj.error) {
      console.log(obj.error);
      return false;
    }

    if (isBackgroundUpload) {
      config.video = (obj.video === 1);
    }

    if (obj.video === 1) {
      config.videofile = obj.videofile;
      config.filename = obj.filename;
      config.videoduration = obj.videoduration;
      $('#width').val(obj.originalWidth);
      $('#height').val(obj.originalHeight);
    }

    redrawCockpit();

    switch (id) {
      case 'uploadfile':
        show('show-copyright');
        afterUpload(obj);
        break;
      case 'uploadlogo':
        $('#logoselect').val('custom');
        logo.load();
        break;
      case 'uploadicon':
        $('#iconfile').val(obj.iconfile);
        icon.load();
        $('.iconsizeselectwrapper').removeClass('d-none');
        break;
      case 'uploadaddpic1':
        $('#addpicfile1').val(obj.addpicfile);
        show('show-add-pic-1');
        show('show-copyright');
        show('show-add-pic-upload');
        addPic1.draw();
        break;
      case 'uploadaddpic2':
        $('#addpicfile2').val(obj.addpicfile);
        show('show-add-pic-2');
        show('show-copyright');
        addPic2.draw();
        break;
      case 'uploadwork':
        {
          const json = JSON.parse(obj.data);
          if (json.addpicfile1 !== '') { json.addpicfile1 = `../${obj.dir}/${json.addpicfile1}`; }
          if (json.addpicfile2 !== '') { json.addpicfile2 = `../${obj.dir}/${json.addpicfile2}`; }
          uploadFileByUrl(`${obj.dir}/${json.savedBackground}`, () => {
            loadFormData(json);
          });
        }
        break;
      default:
        console.log('error in upload', obj);
    }
    return true;
  };

  client.upload.onprogress = function onProgress(e) {
    const p = Math.round((100 / e.total) * e.loaded);
    $('#uploadpercentage').html(p);
  };

  client.onabort = function onAbort() {
    console.log('Upload abgebrochen');
  };

  client.open('POST', '/actions/upload.php');
  client.send(formData);
  return true;
});

function uploadFileByUrl(url, callback = function uploadCallback() {}) {
  $('#waiting').addClass('active');
  const id = 'uploadbyurl';

  const formData = new FormData();
  const client = new XMLHttpRequest();
  formData.append('id', id);
  formData.append('url2copy', url);
  formData.append('csrf', config.csrf);

  client.onerror = function onError(e) {
    console.log('onError', e);
  };

  client.upload.onprogress = function onProgress(e) {
    const p = Math.round((100 / e.total) * e.loaded);
    $('#uploadpercentage').html(p);

    if (p > 99) {
      $('#uploadstatus').html('Dein Bild wird verarbeitet...');
    }
  };

  client.onload = function onLoad(e) {
    const obj = JSON.parse(e.target.response);

    closeOverlay();

    if (obj.error) {
      console.log(obj);
    }

    config.filename = obj.filename;
    config.video = (obj.video === 1);
    if (obj.video === 1) {
      config.videofile = obj.videofile;
      config.filename = obj.filename;
      config.videoduration = obj.videoduration;

      $('#width').val(obj.originalWidth);
      $('#height').val(obj.originalHeight);
    }

    redrawCockpit();

    afterUpload(obj);
    callback();
  };

  client.open('POST', '/actions/upload.php');
  client.send(formData);
}

function afterUpload(data) {
  draw.size(data.width, data.height);
  info.originalWidth = data.originalWidth;
  info.originalHeight = data.originalHeight;
  info.previewWidth = draw.width();
  info.previewHeight = draw.height();

  $('#backgroundURL').val(data.filename);

  // resize after bg upload
  $('#width').val(data.originalWidth);
  $('#height').val(data.originalHeight);

  $('#fullBackgroundName').val(data.fullBackgroundName);

  setDrawsize();

  // unselect presets
  $('#sizepresets').val($('#sizepresets option:first').val());

  background.draw();

  if (data.warning === 'face') {
    $('#warning').html('Das Bild zeigt ein Gesicht. Du brauchst die Erlaubnis der abgebildeten Person, um das Foto zu verwenden.').show(1000).delay(6000)
      .hide(1000);
  } else {
    $('#warning').hide();
  }
}

$('.uploadfileclicker').click(() => {
  $('#uploadfile').click();
});

$('.uploadlogoclicker').click(() => {
  $('#uploadlogo').click();
});

$('.uploadiconclicker').click(() => {
  $('#uploadicon').click();
});
$('.uploadworkclicker').click(() => {
  document.getElementById('pic').reset();
  reDraw();
  $('#uploadwork').click();
});

$('.addpicclicker1').click(() => {
  $('#uploadaddpic1').click();
});
$('.addpicclicker2').click(() => {
  $('#uploadaddpic2').click();
});
