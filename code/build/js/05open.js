function open() {
  $.ajax({
    type: 'POST',
    url: '/actions/open.php',
    data: {
        file_number: 1,
        tenant: config.tenant
    },
    success(data) {
        const obj = JSON.parse(data);
        if(obj.code != 0) {
          //alert("Es wurde kein gespeichert Sharepic gefunden.");
          return;
        }

        const pic = JSON.parse(obj.content);
        fillForm(pic);
        applyBackground(pic);
        applyFormWithoutBackground();
        defaultlogo.draw();
        undo.save();

    },
  });
}

function fillForm(pic) {
  for(let name in pic) {
    $(`#${name}`).val(pic[name]);
  }

  const checkboxes= {'textShadow': '', 'greenify': ''};
  for(let name in checkboxes ) {
    if(pic[name] !== undefined) {
      $(`#${name}`).prop('checked', true);
    }
  }
}

function applyBackground(pic) {
  background.drawColor();
  if(pic['fullBackgroundName'] != "") {
    uploadFileByUrl(pic['fullBackgroundName'], function () {
      window.setTimeout(
        () => greenify(),
        10
      );
    });
  }
}


function applyFormWithoutBackground() {
  $('#width').trigger('propertychange');
  $('#text').trigger('propertychange');
  $('#pintext').trigger('propertychange');
  $('#addtext').trigger('propertychange');

  defaultlogo.setPosition();
  defaultlogo.resize();
}
