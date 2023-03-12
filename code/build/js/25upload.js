/* eslint-disable no-undef */
$('.upload-file').change(function() { 
  const id = $(this).attr('id');
  changeFile(document.getElementById(id).files[0], id); 
});
  
function changeFile(file, id) {
  const size = file.size / 1024 / 1024;

  const maxFileSize = 20; // in MB, note this in .htaccess as well
  const isBackgroundUpload = ($('.upload-file').attr('id') === 'uploadfile');
  if (size > maxFileSize) {
    alert(`Die Datei ist zu groß. Es sind maximal ${maxFileSize} MB erlaubt.`);
    return false;
  }

  $('#canvas-area').slideUp();
  $('#waiting').show();
  $(`#${id}`).prop('disabled', true);

  const formData = new FormData();
  const client = new XMLHttpRequest();

  if (!file) {
    return false;
  }

  formData.append('file', file);
  formData.append('id', id);
  formData.append('csrf', config.csrf);
  formData.append('tenant', config.tenant);

  client.onerror = function onError(e) {
    console.log('onError', e);
  };

  client.onload = function onLoad(e) {
    const obj = JSON.parse(e.target.response);

    $(`#${id}`).prop('disabled', false);
    $('#waiting').hide();
    $('#canvas-area').slideDown();

    if (obj.error) {
      alert('Es ist ein Fehler beim Upload aufgetreten.');
      console.log(obj.error);
      return false;
    }

    switch (id) {
      case 'uploadfile':
        show('show-copyright');
        $('#backgroundsize').val(draw.width());
        $('.picture-only').toggleClass('d-none', false);
        log.source = 'upload';
        afterUpload(obj);
        break;
      case 'uploadlogo':
        $('#logofile').val(obj.logo);
        config.user.prefs.logofile = obj.logo;
        setUserPrefs();
        defaultlogo.draw(obj.logo);
        break;
      case 'uploadaddpic1':
        handleAddPicUpload(1, obj);
        break;
      case 'uploadaddpic2':
        handleAddPicUpload(2, obj);
        break;
      case 'uploadaddpic3':
        handleAddPicUpload(3, obj);
        break;
      case 'uploadaddpic4':
        handleAddPicUpload(4, obj);
        break;
      case 'uploadaddpic5':
        handleAddPicUpload(5, obj);
        break;
      default:
        console.log('error in upload', obj);
    }
    return true;
  };

  client.upload.onprogress = function onProgress(e) {
    const p = Math.round((100 / e.total) * e.loaded);

    showStatus(p);
  };

  client.onabort = function onAbort() {
    console.log('Upload abgebrochen');
  };

  client.open('POST', '/actions/upload.php');
  client.send(formData);
  return true;
}

function handleAddPicUpload(nr, obj){
  $('#addpicfile' + nr).val(obj.addpicfile);
  show('show-add-pic-' + nr);
  show('show-copyright');
  show('add-pic-tools-' + nr);
  show('show-add-pic-upload-' + (nr + 1));
  hide('addpicclicker' + nr);
  window['addPic' + nr ].draw();
}

function uploadFileByUrl(url, callback = function uploadCallback() {}) {
  $('#waiting').show();
  $('#canvas-area').slideUp();
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

    showStatus(p);
  };

  client.onload = function onLoad(e) {
    const obj = JSON.parse(e.target.response);

    $('#waiting').hide();
    $('#canvas-area').slideDown();

    if (obj.error) {
      console.log(obj);
    }

    config.filename = obj.filename;   
    log.source = 'pixabay';
    log.pixabaysearchterm = $('#imagedb-direct-search-q').val();

    afterUpload(obj);
    $('.picture-only').toggleClass('d-none', false);
   
    callback();
  };

  client.open('POST', '/actions/upload.php');
  client.send(formData);
}

function showStatus(p) {
  if (p < 95) {
    $('#uploadbar').show();
    $('#uploadstatus').show();
    $('#beinguploaded').html('Deine Datei wird hochgeladen.');
    $('#uploadpercentage').html(p);
    $('#uploadbar div').width(`${p}%`);
    $('#waiting .loader').hide();
  } else {
    $('#uploadstatus').hide();
    $('#beinguploaded').html('Deine Datei wird verarbeitet.');
    $('#uploadbar').hide();
    $('#waiting .loader').show();
  }
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

  background.reset();
  //background.draw();

  config.backgroundSource = 'upload';
}

$('.uploadfileclicker').click(() => {
  $('#uploadfile').click();
});

$('.uploadlogoclicker').click(() => {
  $('#uploadlogo').click();
});

for (let i = 1; i <= 5; i++) {
  $(`.addpicclicker${i}`).click(() => {
    $(`#uploadaddpic${i}`).click();
  });
}


