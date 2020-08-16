function loadFormData(formdata) {
  // set the draw size manually, because it recalculates boundaries, etc.
  $('#width').val(formdata.width);
  $('#height').val(formdata.height);
  setDrawsize();

  for (const elem in formdata) {
    $(`#${elem}`).val(formdata[elem]);
  }

  const checkboxes = ['textsamesize', 'greenbehindtext', 'graybehindtext', 'addpicrounded1', 'addpicrounded2'];
  checkboxes.forEach((elem) => {
    if (formdata[elem] === 'on') {
      $(`#${elem}`).prop('checked', true);
      $(`#${elem}`).bootstrapToggle('on');
    }
  });

  window.setTimeout(() => {
    text.draw();
    logo.load();
    // background.draw();
    copyright.draw();
    pin.draw();
    icon.load();
    // addPic1.draw();
    // addPic2.draw();
    showLayout();
  }, 100);

  window.setTimeout(() => {
    copyright.draw(); // unknow, why this has to be performed later
    pin.draw();
  }, 500);
}

function savework() {
  const data = $('#pic').serialize();

  $.ajax({
    type: 'POST',
    url: '/actions/savework.php',
    data: { data },
    success(data, textStatus, jqXHR) {
      const obj = JSON.parse(data);
      const downloadname = getDownloadName();
      window.location.href = `/actions/downloadwork.php?basename=${obj.basename}&downloadname=${downloadname}`;
    },
  });
}
