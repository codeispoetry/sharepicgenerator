$(document).ready(() => {
  if (config.user.prefs.darkmode) {
    $('#darkmode').prop('checked', true);
  } else {
    $('#darkmode').prop('checked', false);
  }

  $('#darkmode').bind('change', () => {
    $('body').toggleClass('dark');
    config.user.prefs.darkmode = !$('#darkmode').prop('checked');
    setUserPrefs();
  });
});
