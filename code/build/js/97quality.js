$('#quality').bind('input propertychange', adjustQuality);

function adjustQuality() {
  config.quality = $('#quality').val();
}
