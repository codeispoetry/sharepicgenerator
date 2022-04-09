$('.upload-file').change(function changeFile() {
  const id = $(this).attr('id');
  const file = document.getElementById(id).files[0];
  const size = document.getElementById(id).files[0].size / 1024 / 1024;

  const maxFileSize = 20; // in MB, note this in .htaccess as well
  const isBackgroundUpload = ($(this).attr('id') === 'uploadfile');
  if (size > maxFileSize) {
    alert(`Die Datei ist zu groß. Es sind maximal ${maxFileSize} MB erlaubt.`);
    return false;
  }

  $('#canvas-area').slideUp();
  $('#waiting').show();
  $(this).prop('disabled', true);

  const formData = new FormData();
  const client = new XMLHttpRequest();

  const startUploadTime = Date.now();

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

    if (isBackgroundUpload) {
      config.video = (obj.video === 1);
    }

    if (obj.video === 1) {
      config.videofile = obj.videofile;
      config.filename = obj.filename;
      config.videoduration = obj.videoduration;
      $('#width').val(obj.originalWidth);
      $('#height').val(obj.originalHeight);
      $('#graybackground').val(1);
      $('#blurbackground').val(0);
      $('#darklightlayer').val(0);
      $('#greenlayer').val(0);
    }

    redrawCockpit();

    switch (id) {
      case 'uploadfile':
        show('show-copyright');
        config.uploadTime = Date.now() - startUploadTime;
        afterUpload(obj);
        break;
      case 'uploadlogo':
        alert('Um das neue Logo nutzen zu können, lade bitte den Sharepicgenerator neu (F5).');
        break;
      case 'uploadtmplogo':
        logo.loadTmp(`/tmp/${obj.file}`);
        break;
      case 'uploadfont':
        console.log(obj);
        $('head').append(`<style>@font-face { font-family: "${obj.name}"; src: url("${obj.url}") format("woff2"); }</style>`);

        $('#textfont').append(new Option(obj.name, obj.name));
        $('#textfont').val(obj.name);
        basic.draw();

        break;
  
      case 'uploadaddpic1':
        $('#addpicfile1').val(obj.addpicfile);
        show('show-add-pic-1');
        show('show-copyright');
        show('show-add-pic-upload');
        show('add-pic-tools-1');
        $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
        addPic1.draw();
        break;
      case 'uploadaddpic2':
        $('#addpicfile2').val(obj.addpicfile);
        show('show-add-pic-2');
        show('show-copyright');
        show('add-pic-tools-2');
        $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
        addPic2.draw();
        break;
      case 'uploadaddpic3':
        $('#addpicfile3').val(obj.addpicfile);
        show('show-add-pic-3');
        show('show-copyright');
        show('add-pic-tools-3');
        $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
        addPic3.draw();
        break;
      case 'uploadaddpic4':
        $('#addpicfile4').val(obj.addpicfile);
        show('show-add-pic-4');
        show('show-copyright');
        show('add-pic-tools-4');
        $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
        addPic4.draw();
        break;
      case 'uploadaddpic5':
        $('#addpicfile5').val(obj.addpicfile);
        show('show-add-pic-5');
        show('show-copyright');
        show('add-pic-tools-5');
        $('.retoggle').bootstrapToggle('destroy').bootstrapToggle();
        addPic5.draw();
        break;
      case 'uploadwork':
        {
          const json = JSON.parse(obj.data);
          if (json.addpicfile1) { json.addpicfile1 = `../${obj.dir}/${json.addpicfile1}`; show('add-pic-tools-1'); }
          if (json.addpicfile2) { json.addpicfile2 = `../${obj.dir}/${json.addpicfile2}`; show('add-pic-tools-2'); }
          if (json.addpicfile3) { json.addpicfile3 = `../${obj.dir}/${json.addpicfile3}`; show('add-pic-tools-3'); }
          if (json.addpicfile4) { json.addpicfile4 = `../${obj.dir}/${json.addpicfile4}`; show('add-pic-tools-4'); }
          if (json.addpicfile5) { json.addpicfile5 = `../${obj.dir}/${json.addpicfile5}`; show('add-pic-tools-5'); }

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

    showStatus(p);
  };

  client.onabort = function onAbort() {
    console.log('Upload abgebrochen');
  };

  client.open('POST', '/actions/upload.php');
  client.send(formData);
  return true;
});

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

  background.draw();
  if (data.faces === undefined) {
    config.faces = -1;
  } else {
    config.faces = data.faces;
  }

  config.backgroundSource = 'upload';
}

$('.uploadfileclicker').click(() => {
  $('#uploadfile').click();
});

$('.uploadlogoclicker').click(() => {
  $('#uploadlogo').click();
});

$('.uploadtmplogoclicker').click(() => {
  $('#uploadtmplogo').click();
});

$('.uploadfontclicker').click(() => {
  $('#uploadfont').click();
});

$('.uploadiconclicker').click(() => {
  $('#uploadicon').click();
});
$('.uploadworkclicker').click(() => {
  document.getElementById('pic').reset();
  reDraw();
  $('#uploadwork').click();
});

for (let i = 1; i <= 5; i++) {
  $(`.addpicclicker${i}`).click(() => {
    $(`#uploadaddpic${i}`).click();
  });
}
