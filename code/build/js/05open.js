$('#open').click(function onSaveClick() {
  $(this).prop('disabled', true).val('Opening file...');
  const oldVal = $(this).val();

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
          alert("Es wurde kein gespeichert Sharepic gefunden.");
          return;
        }

        const pic = JSON.parse(obj.content);
        fillForm(pic);
        $('#open').prop('disabled', false).val(oldVal);
    },
  });
});

function fillForm(pic) {
  if(pic['fullBackgroundName'] != "") {
    uploadFileByUrl(pic['fullBackgroundName']);
  }
  for(let name in pic) {
    $(`#${name}`).val(pic[name]);
  }

  const checkboxes= {'textShadow': ''};
  for(let name in checkboxes ) {
    if(pic[name] == "on") {
    $(`#${name}`).prop('checked', true);
    }
  }

  $('#width').trigger('propertychange');
  $('#text').trigger('propertychange');
  $('#pintext').trigger('propertychange');

 
}
