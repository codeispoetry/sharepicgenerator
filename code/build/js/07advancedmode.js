/* eslint-disable no-undef */

$(document).ready(() => {
  if (config.user.prefs.advancedmode) {
    $('#advancedmode').prop('checked', true);
  } else {
    $('#advancedMode').prop('checked', false);
  }
  $('.advancedmode').toggleClass('d-none', !$('#advancedmode').prop('checked'));

  $('#advancedmode').bind('change', () => {
    $('.advancedmode').toggleClass('d-none', !$('#advancedmode').prop('checked'));
    config.user.prefs.advancedmode = $('#advancedmode').prop('checked');
    setUserPrefs();
  });
});
