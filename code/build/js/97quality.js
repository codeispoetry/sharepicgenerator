$('#quality').bind('input propertychange', setQuality);
$('input[name=fileformat]').click(setFileFormat);

function setQuality() {
  config.quality = $('#quality').val();
}

function setFileFormat() {
  config.format = $(this).val();
  $('#quality').prop('disabled', ($(this).val() !== 'jpg'));
}
