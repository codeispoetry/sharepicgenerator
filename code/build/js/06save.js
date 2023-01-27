$('#save').click(function onSaveClick() {
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
