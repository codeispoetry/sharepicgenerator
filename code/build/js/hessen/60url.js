$('#url').focusout(function () {
  config.user.prefs.url = $(this).val();
  setUserPrefs();
});

$(document).ready(() => {
  if (config.user.prefs.url) {
    $('#url').val(config.user.prefs.url);
  } else {
    $('#url').val('gruene-hessen.de');
  }
});
