$('.deleteWorkfile').on('click', function deleteWorkfile() {
  // eslint-disable-next-line no-restricted-globals
  if (!confirm('Wirklich dauerhaft löschen?')) {
    return;
  }

  $.post('/actions/delete.php', { action: 'workfile', 'workfileiId': $(this).data('id'), csrf: config.csrf })
    .done((response) => {
      const data = JSON.parse(response);
      console.log(data.success);
      if (data.error) {
        console.log(data);
        alert('Die Datei konnte nicht gelöscht werden.');
        return;
      }

      $(this).closest('.samplesharepic').parent().fadeOut(1000);
    });
});
