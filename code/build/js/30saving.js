// eslint-disable-next-line no-unused-vars
function loadFormData(formdata) {
  // set the draw size manually, because it recalculates boundaries, etc.
  $('#width').val(formdata.width);
  $('#height').val(formdata.height);
  setDrawsize();

  // eslint-disable-next-line no-restricted-syntax, guard-for-in
  for (const elem in formdata) {
    $(`#${elem}`).val(formdata[elem]);
  }

  $('form[id="pic"]').find(':checkbox').each((idx, elem) => {
    const elemName = elem.name;
    if (formdata[elemName] === 'on') {
      $(`#${elemName}`).prop('checked', true);
    }
  });

  for (let i = 1; i <= 2; i++) {
    if ($(`#addpicfile${i}`).val()) {
      show(`show-add-pic-${i}`);
    }
  }

  window.setTimeout(() => {
    if (typeof reDraw === 'function') {
      // eslint-disable-next-line no-undef
      reDraw(true);
    }

    if (typeof showLayout === 'function') {
      // eslint-disable-next-line no-undef
      showLayout();
    }

    $('#logosize').val(formdata.logosize);
    logo.resize($('#logosize').val());
  }, 100);
}

// eslint-disable-next-line no-unused-vars
function savework() {
  const data = $('#pic').serialize();
  delete data.fullBackgroundName;

  $.ajax({
    type: 'POST',
    url: '/actions/savework.php',
    data: { csrf: config.csrf, data },
    success(saveWorkData) {
      const obj = JSON.parse(saveWorkData);
      const downloadname = getDownloadName();
      window.location.href = `/actions/downloadwork.php?basename=${obj.basename}&downloadname=${downloadname}`;
    },
  });
}

// eslint-disable-next-line no-unused-vars
function loadSavework(obj) {
  const json = JSON.parse(obj.data);
  if (json.addpicfile1 !== '') { json.addpicfile1 = `../${obj.dir}/${json.addpicfile1}`; }
  if (json.addpicfile2 !== '') { json.addpicfile2 = `../${obj.dir}/${json.addpicfile2}`; }
  uploadFileByUrl(`${obj.dir}/${json.savedBackground}`, () => {
    loadFormData(json);
  });
}
