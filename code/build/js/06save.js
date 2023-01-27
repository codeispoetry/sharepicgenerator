$('#save').click(function onSaveClick() {

  if( config.userHasSavedFile === '1' && ! confirm("Du kannst nur ein Sharepic speichern und hast schon eines. Soll das überschrieben werden?") ){
      return;
  }

  config.userHasSavedFile = '1';

  $(this).prop('disabled', true).val('Saving...');
  const oldVal = $(this).val();

  $.ajax({
    type: 'POST',
    url: '/actions/save.php',
    data: {
      sharepic: $('#pic').serialize(),
      config: JSON.stringify(config),
      log: JSON.stringify(log),
    },
    success(data) {
        const obj = JSON.parse(data);
        $('#save').prop('disabled', false)
        $('#save').val(oldVal);
    },
  });
});
